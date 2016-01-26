<?php

namespace Zaeder\Link4mailingBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class UrlHelper {
    
    private $container;
    private $em;
    private $userRepository;
    private $link4mailingRepository;
    
    function __construct(ContainerInterface $container, EntityManager $entity_manager)
    {
        $this->container = $container;
        $this->em = $entity_manager;
        $this->getUserRepository();
        $this->link4mailingRepository = $this->em->getRepository('ZaederLink4mailingBundle:Link4mailing');
    }
    
    private function getUserRepository()
    {
        $userEntity = $this->container->getParameter('zaederlink4mailingbundle.user_class');
        $userEntityArr = explode('\\', $userEntity);
        $bundleName = $entityName = '';
        for($loop = 0; $loop < count($userEntityArr); $loop++){
            if(isset($userEntityArr[$loop]) && $userEntityArr[$loop] !== '' && isset($userEntityArr[$loop-1]) && $userEntityArr[$loop-1] === 'Entity'){
                $entityName .= $userEntityArr[$loop];
            } elseif(isset($userEntityArr[$loop]) && $userEntityArr[$loop] !== '' && $userEntityArr[$loop] !== 'Entity'){
                $bundleName .= $userEntityArr[$loop];
            }
        }
        if($bundleName !== '' && $entityName !== ''){
            $this->userRepository = $this->em->getRepository($bundleName . ':' . $entityName);
        } else {
            throw new \LogicException('Can\'t find the repository');
        }
    }
}