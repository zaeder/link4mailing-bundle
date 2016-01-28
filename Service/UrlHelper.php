<?php

namespace Zaeder\Link4mailingBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Zaeder\Link4mailingBundle\Entity\Link4mailing;

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
     */
    function __construct(ContainerInterface $container, EntityManager $entity_manager)
    {
        $this->container = $container;
        $this->em = $entity_manager;
        $this->userRepository = $this->em->getRepository($this->container->getParameter('zaederlink4mailingbundle.user_class'));
        $this->link4mailingRepository = $this->em->getRepository('ZaederLink4mailingBundle:Link4mailing');
    }
    
    /**
     * Generate link
     * @param string $routeName
     * @param mixed $routeParams
     * @param int $userId
     * @param int $duration
     */
    public function generateLink($routeName, $routeParams = array(), $userId = 0, $duration = 0)
    {
        $link4mailing = new Link4mailing();
        if(is_array($routeParams)){
            $this->container->get('router')->generate($routeName, $routeParams);
        } else {
            throw new \LogicException('$routeName must be an array');
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
        $link4mailing->setRouteName($routeName)
                     ->setRouteParams(json_encode($routeParams))
                     ->setToken($token)
                     ->setUserId($userId)
                     ->setIsActive(1);
        $this->em->persist($link4mailing);
        $this->em->flush();
        return $this->container->get('router')->generate('zaeder.link4mailing', array(
            'linkId' => $link4mailing->getId(),
            'securKey' => md5($routeName . $token . json_encode($routeParams))
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
            if($securKey === md5($link4mailing->getRouteName() . $link4mailing->getToken() . $link4mailing->getRouteParams())){
                if($link4mailing->getUserId() !== 0){
                    $this->autologin($link4mailing->getUserId());
                }
                return $this->container->get('router')->generate($link4mailing->getRouteName(), json_decode($link4mailing->getRouteParams()));
            } else {
                throw new \Exception('This link is not valid');
            }
        } else {
            throw new \Exception('Not found link');
        }
    }
    
    private function autologin($userId)
    {
        $user = $this->userRepository->find($userId);
    }
}