<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Video;
use AppBundle\Entity\Playlist;

class AjaxController extends Controller
{

    /**
     * @Route("/ajax-tester", name="app_admin_ajax_tester")
     */
    public function testAction(Request $request)
    {
        $id = $request->query->get('id');
        $infos = file_get_contents('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v='.$id.'&format=json');
        // $title = $infos->title;
        // $infos = Request::create(
        //     "http://www.youtube.com/oembed",
        //     "GET",
        //     array(
        //         "url" => "http://www.youtube.com/watch?v=".$id,
        //         "format" => "json"
        //     ),
        //     array(),
        //     array(),
        //     array("Content-Type" => "application/json")
        // );
        // $infos = json_encode(http_get("http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=".$id."&format=json", array("Content-Type" => "application/json")));
        return new Response($infos, 200, array());
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

    /**
     * @Route("/add-youtube-video", name="app_admin_add_youtube_video")
     * @Method("POST")
     */
    public function addYoutubeVideoAction(Request $request)
    {
        $id = $request->request->get('url');
        $infos = json_decode(file_get_contents('http://www.youtube.com/oembed?url='.$id.'&format=json'));
        $title = $infos->title;
        $author = $infos->author_name;
        $duration = 120;
        $embed_code = $infos->html;

        $video = new Video();
        $video->setTItle($title);
        $video->setAuthor($author);
        $video->setDuration($duration);
        $video->setEmbedCode($embed_code);
        $em = $this->getDoctrine()->getManager();
        $em->persist($video);
        $em->flush();

        return new Response('Vidéo '.$infos->provider_name.' bien ajoutée !', 200, array('Content-Type' => 'text/html'));
    }

    /**
     * @Route("/get-videos", name="app_admin_show_playlist_videos")
     * @Method("GET")
     */
    public function showVideosByPlaylist(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $playlistId = $request->query->get('playlist_id');
            $playlist = $this->getDoctrine()->getRepository('AppBundle:Playlist')->find($playlistId);

            if (!$playlist) {
                throw $this->createNotFoundException('Unable to find Playlist entity.');
            }

            return $this->render('AppBundle:Admin:partials/list-videos.html.twig', array('playlist' => $playlist));
        } else {
            throw $this->createAccessDeniedException('Ce que vous voulez voir n\'est pas accessible.');
        }

    }
}
