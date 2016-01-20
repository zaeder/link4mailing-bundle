<?php

namespace Zaeder\Link4MailingBundle\Service;

class UrlHelper {
    
    private $container;
    
    function __construct($container)
    {
        $this->container = $container;
    }
}