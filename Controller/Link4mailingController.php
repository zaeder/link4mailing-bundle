<?php

namespace Zaeder\Link4mailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Link4mailingController extends Controller
{
    /**
     * Redirect to final url with wanted treatments
     * @param $linkId
     * @param $securKey
     *
     * @return RedirectResponse
     * @Route("/Link4mailing/{linkId}/{securKey}", name="Link4mailing")
     */
    public function Link4mailingAction($linkId, $securKey)
    {
        $request = $this->container->get('request');
        $url = 'http://'.$request->getHost().$request->getBaseUrl().'/';

    	$response = new RedirectResponse($url);
    	
    	return $response;
    }   
}
