<?php

namespace Zaeder\Link4mailingBundle\Service;

class UrlHelper {
    
    private $container;
    
    function __construct($container)
    {
        $this->container = $container;
    }
}