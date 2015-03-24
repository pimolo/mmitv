<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{

    /**
     * @Route("/ajax-tester", name="app_admin_ajax_tester")
     */
    public function testAction()
    {
	$text = "BIen joué !";

	return new Response('Content', 200, array('Content-Type', 'text/plain'));
    }
}
