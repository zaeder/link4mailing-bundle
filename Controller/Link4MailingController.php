<?php

namespace Zaeder\Link4MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Link4MailingController extends Controller
{
    /**
     * Redirect to final url with wanted treatments
     * @param $linkId
     * @param $securKey
     *
     * @return RedirectResponse
     * @Route("/link4mailing/{linkId}/{securKey}", name="link4mailing")
     */
    public function link4mailingAction($linkId, $securKey)
    {
        $request = $this->container->get('request');
        $url = 'http://'.$request->getHost().$request->getBaseUrl().'/';

    	$response = new RedirectResponse($url);
    	
    	return $response;
    }   
}
