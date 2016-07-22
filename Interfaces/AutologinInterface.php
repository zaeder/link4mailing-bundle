<?php

namespace Zaeder\Link4mailingBundle\Interfaces;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use FOS\UserBundle\Security\LoginManagerInterface;

interface AutologinInterface {
    /**
     * Init vars
     * @param EntityManagerInterface $em
     * @param SecurityContextInterface $securityContext
     * @param LoginManagerInterface $loginManager
     * @param string $userEntityClassName
     * @param string $firewallName
     */
    public function __construct(EntityManagerInterface $em, SecurityContextInterface $securityContext, LoginManagerInterface $loginManager, $userEntityClassName, $firewallName);
    
    /**
     * Autolog and redirect
     * @param string $url
     * @param int $userId
     */
    public function autologin($url, $userId);
}