<?php

namespace Zaeder\Link4mailingBundle\Service;

class UrlHelper {
    
    private $container;
    private $userEntity;
    private $link4mailingEntity;
    
    function __construct($container)
    {
        $this->container = $container;
        $userEntity = $this->container->getParameter('zaederlink4mailingbundle.user_class');
        $this->userEntity = new $userEntity;
        $this->link4mailingEntity = $this->container->getEntityManager()->getRepository('ZaederLink4mailingBundle:Link4mailing');
    }
}