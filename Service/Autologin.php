<?php

namespace Zaeder\Link4mailingBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class Autologin {
    
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
     * Init vars
     * @param ContainerInterface $container
     * @param EntityManager $entity_manager
     */
    function __construct(ContainerInterface $container, EntityManager $entity_manager)
    {
        $this->container = $container;
        $this->em = $entity_manager;
    }
    
    public function autologin($url, $userId)
    {
    	$user = $this->container->get('security.context')->getToken()->getUser();
        
        if($user == "anon."){
            $response = new RedirectResponse($url);
    	}
    	else {
            $reUser = $this->em->getRepository($this->container->getParameter('zaederlink4mailingbundle.user_class'));
            $user = $reUser->find($userId);

            $response = new RedirectResponse($url);
            if($user != null) {
                $this->authenticateUser($user, $response);
            }
    	}
    }
    
    protected function authenticateUser($user, Response $response)
    {
        $userClass = $this->container->getParameter('zaederlink4mailingbundle.user_class');
        if(!($user instanceof $userClass)){
            throw new \Exception('User invalid');
        }
    	try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response
            );
    	} catch (AccountStatusException $ex) {
    		// We simply do not authenticate users which do not pass the user
    		// checker (not enabled, expired, etc.).
    	}
    }
}