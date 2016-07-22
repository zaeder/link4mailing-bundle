<?php

namespace Zaeder\Link4mailingBundle\Service;

use Zaeder\Link4mailingBundle\Interfaces\AutologinInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use FOS\UserBundle\Security\LoginManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class Autologin implements AutologinInterface {
    
    /**
     * Entity Manager
     * @var Doctrine\ORM\EntityManagerInterface
     */
    private $em;
    /**
     * Security Context
     * @var Symfony\Component\Security\Core\SecurityContextInterface
     */
    private $securityContext;
    /**
     * Login Manager
     * @var FOS\UserBundle\Security\LoginManagerInterface
     */
    private $loginManager;
    /**
     * User entity classname
     * @var string
     */
    private $userEntityClassName;
    /**
     * Firewall name
     * @var string
     */
    private $firewallName;
    
    /**
     * Init vars
     * @param EntityManagerInterface $em
     * @param SecurityContextInterface $securityContext
     * @param LoginManagerInterface $loginManager
     * @param string $userEntityClassName
     * @param string $firewallName
     */
    public function __construct(EntityManagerInterface $em, SecurityContextInterface $securityContext, LoginManagerInterface $loginManager, $userEntityClassName, $firewallName)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->loginManager = $loginManager;
        $this->userEntityClassName = $userEntityClassName;
        $this->firewallName = $firewallName;
    }
    
    /**
     * Autolog and redirect
     * @param string $url
     * @param int $userId
     */
    public function autologin($url, $userId)
    {
    	$user = $this->securityContext->getToken()->getUser();
        
        if($user == "anon."){
            $response = new RedirectResponse($url);
    	}
    	else {
            $reUser = $this->em->getRepository($this->userEntityClassName);
            $user = $reUser->find($userId);

            $response = new RedirectResponse($url);
            if($user != null) {
                $this->authenticateUser($user, $response);
            }
    	}
    }
    
    private function authenticateUser($user, Response $response)
    {
        if(!($user instanceof $this->userEntityClassName)){
            throw new \Exception('User invalid');
        }
    	try {
            $this->loginManager->loginUser(
                $this->firewallName,
                $user,
                $response
            );
    	} catch (AccountStatusException $ex) {
    		// We simply do not authenticate users which do not pass the user
    		// checker (not enabled, expired, etc.).
    	}
    }
}