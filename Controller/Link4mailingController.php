<?php

namespace Zaeder\Link4mailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Link4mailingController extends Controller
{
    public function Link4mailingAction($linkId, $securKey)
    {
        $request = $this->get('request');
        $url = 'http://'.$request->getHost().$request->getBaseUrl().'/';

    	$response = new RedirectResponse($url);
    	
    	return $response;
    }   
}
