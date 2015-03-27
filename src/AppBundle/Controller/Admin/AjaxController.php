<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Video;

class AjaxController extends Controller
{

    /**
     * @Route("/ajax-tester", name="app_admin_ajax_tester")
     */
    public function testAction()
    {
        return new Response("C'est ok", 200, array('Content-Type', 'text/plain'));
    }

    /**
     * @Route("/add-video", name="app_admin_add_video")
     * @Method("POST")
     */
    public function addVideoAction(Request $request)
    {
        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $duration = $request->request->get('duration');
        $embed_code = $request->request->get('html');

        $video = new Video();
        $video->setTItle($title);
        $video->setAuthor($author);
        $video->setDuration($duration);
        $video->setEmbedCode($embed_code);
        $em = $this->getDoctrine()->getManager();
        $em->persist($video);
        $em->flush();

        return new Response('Vidéos bien ajoutées !', 200, array('Content-Type' => 'text/plain'));
    }
}
