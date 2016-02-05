<?php

namespace Zaeder\Link4mailingBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Zaeder\Link4mailingBundle\Entity\Link4mailing;
use Zaeder\Link4mailingBundle\Service\Autologin;
use Teknoo\Curl\RequestGenerator;
use Teknoo\Curl\ErrorException as TeknooCurlException;

class UrlHelper {
    
    /**
     * Container
     * @var Symfony\Component\DependencyInjection\ContainerInterface 
     */
    private $container;
    /**
     * Entity Manager
     * @var Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * Autologin
     * @var Zaeder\Link4mailingBundle\Service\Autologin
     */
    private $autologin;
    /**
     * User repository
     * @var object
     */
    private $userRepository;
    /**
     * Link4mailing repository
     * @var Zaeder\Link4mailingBundle\Entity\Link4mailing
     */
    private $link4mailingRepository;
    
    /**
     * Init vars
     * @param ContainerInterface $container
     * @param EntityManager $entity_manager
     * @param Autologin $autologin
     */
    function __construct(ContainerInterface $container, EntityManager $entity_manager, Autologin $autologin)
    {
        $this->container = $container;
        $this->em = $entity_manager;
        $this->autologin = $autologin;
        $this->userRepository = $this->em->getRepository($this->container->getParameter('zaederlink4mailingbundle.user_class'));
        $this->link4mailingRepository = $this->em->getRepository('ZaederLink4mailingBundle:Link4mailing');
    }
    
    /**
     * Generate link
     * @param string $routeNameOrUri
     * @param mixed $routeParams
     * @param boolean $isExternalLink
     * @param int $userId
     * @param int $duration
     */
    public function generateLink($routeNameOrUri, $routeParams = array(), $isExternalLink = false, $userId = 0, $duration = 0)
    {
        $link4mailing = new Link4mailing();
        if($isExternalLink === true){
            if($this->checkExternalLink($routeNameOrUri)){
                $routeParams = array();
            } else {
                throw new \Exception('This link "' . $routeNameOrUri . '" is not valid');
            }
        } else {
            if(is_array($routeParams)){
                $this->container->get('router')->generate($routeNameOrUri, $routeParams);
            } else {
                throw new \LogicException('$routeName must be an array');
            }
        }
        if(!is_int($userId)) {
            throw new \LogicException('$userId must be an integer');
        }
        if(!is_int($duration)) {
            throw new \LogicException('$duration must be an integer');
        } elseif($duration > 0){
            $time = strtotime('+' . $duration . ' hour');
            $expirationDate = new \DateTime();
            $expirationDate->setTimestamp($time);
            $link4mailing->setExpirationDate($expirationDate);
        }
        $token = md5(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!:;,§/.?*ùµ%|_-#=()'), 0, 30));
        $link4mailing->setRouteNameOrUri($routeNameOrUri)
                     ->setRouteParams(json_encode($routeParams))
                     ->setToken($token)
                     ->setUserId($userId)
                     ->setIsExternalLink($isExternalLink)
                     ->setIsActive(1);
        $this->em->persist($link4mailing);
        $this->em->flush();
        return $this->container->get('router')->generate('zaeder.link4mailing', array(
            'linkId' => $link4mailing->getId(),
            'securKey' => md5($routeNameOrUri . $token . json_encode($routeParams))
        ));
    }
    
    public function getLink($linkId, $securKey)
    {
        $link4mailing = $this->link4mailingRepository->find($linkId);
        if($link4mailing instanceof Link4mailing && $link4mailing->getIsActive() === true){
            $date = new \DateTime();
            $expirationDate = $link4mailing->getExpirationDate();
            if(!is_null($expirationDate) && $expirationDate < $date){
                throw new \Exception('This link has expired');
            }
            if($securKey === md5($link4mailing->getRouteNameOrUri() . $link4mailing->getToken() . $link4mailing->getRouteParams())){
                if($link4mailing->getIsExternalLink()){
                    $url = $link4mailing->getRouteNameOrUri();
                } else {
                    $url = $this->container->get('router')->generate($link4mailing->getRouteNameOrUri(), json_decode($link4mailing->getRouteParams()));
                }
                if($link4mailing->getUserId() !== 0){
                    $this->autologin->autologin($url, $link4mailing->getUserId());
                }
                return $url;
            } else {
                throw new \Exception('This link is not valid');
            }
        } else {
            throw new \Exception('Not found link');
        }
    }
    
    private function checkExternalLink($url)
    {
        $valid = true;
        $generator = new RequestGenerator();
        $request = $generator->getRequest();
        $request->setUrl($url)
                ->setMethod('GET');
        try {
            $request->execute();
        } catch (TeknooCurlException $e) {
            $valid = false;
        }
        return $valid;
    }
}