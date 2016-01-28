<?php

namespace Zaeder\Link4mailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Link4mailingController extends Controller
{
    public function Link4mailingAction($linkId, $securKey)
    {
    	$response = new RedirectResponse($this->get('Link4mailing_urlhelper')->getLink($linkId, $securKey));
    	
    	return $response;
    }   
}
