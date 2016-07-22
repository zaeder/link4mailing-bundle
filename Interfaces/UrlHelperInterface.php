<?php

namespace Zaeder\Link4mailingBundle\Interfaces;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\RouterInterface;
use Zaeder\Link4mailingBundle\Interfaces\AutologinInterface;

interface UrlHelperInterface {
    /**
     * Init vars
     * @param EntityManager $entity_manager
     * @param AutologinInterface $autologin
     * @param RouterInterface $router
     * @param string $userRepositoryClass
     */
    public function __construct(EntityManager $entity_manager, AutologinInterface $autologin, RouterInterface $router, $userRepositoryClass);
    
    /**
     * Generate link
     * @param string $routeNameOrUri
     * @param mixed $routeParams
     * @param boolean $isExternalLink
     * @param int $userId
     * @param int $duration
     */
    public function generateLink($routeNameOrUri, $routeParams = array(), $isExternalLink = false, $userId = 0, $duration = 0);
    
    /**
     * Get link to redirect on
     * @param string $linkId
     * @param string $securKey
     */
    public function getLink($linkId, $securKey);
}