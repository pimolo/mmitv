<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Video;

class VideoPlannerController extends Controller
{
    /**
     * @Route("/plan-video", name="app_admin_plan_video")
     * @Method("POST")
     */
    public function planVideoAction(Request $request)
    {
        $id = $request->request->get('video_id');
        $beginningDate = $request->request->get('beginning_date');
        $em = $this->getDoctrine()->getManager();

        $video = $em->getRepository('AppBundle:Video')->find($id);
        $video->setBeginningDate($beginningDate);
        $em->flush();

        return new Response('OK', 200);
    }

    /**
     * @Route("/get-videos-planning", name="app_admin_show_playlist_videos_planning")
     * @Method("GET")
     */
    public function showVideosByPlaylistAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $playlistId = $request->query->get('playlist_id');
            $playlist = $this->getDoctrine()->getRepository('AppBundle:Playlist')->find($playlistId);

            if (!$playlist) {
                throw $this->createNotFoundException('Unable to find Playlist entity.');
            }

            return $this->render('AppBundle:Admin:partials/list-videos-planning.html.twig', array('playlist' => $playlist));
        } else {
            throw $this->createAccessDeniedException('Ce que vous voulez voir n\'est pas accessible.');
        }

    }
}
