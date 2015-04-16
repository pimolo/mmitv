<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Video;

class MainController extends Controller
{
    /**
     * @Route("/", name="app_admin_accueil")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Admin:main/index.html.twig');
    }

    /**
     * @Route("/videos", name="app_admin_videos")
     */
    public function videosAction()
    {
        $playlists = $this->getDoctrine()->getRepository('AppBundle:Playlist')->findAll();

        return $this->render('AppBundle:Admin:main/video.html.twig', array('playlists' => $playlists));
    }

    /**
     * @Route("/utilisateurs", name="app_admin_utilisateurs")
     */
    public function usersAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('AppBundle:Admin:main/users.html.twig', array('redacteurs' => $users));
    }

    /**
     * @Route("/planning", name="app_admin_planning")
     * @Template()
     */
    public function planningAction()
    {
        $playlists = $this->getDoctrine()->getRepository('AppBundle:Playlist')->findAll();
        $videos = $this->getDoctrine()->getRepository('AppBundle:Video')->findAll();

        return array('playlists' => $playlists, 'videos' => $videos);
    }
}
