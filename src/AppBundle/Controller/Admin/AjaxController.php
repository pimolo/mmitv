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
        $em = $this->getDoctrine()->getManager();

        $url = $request->request->get('url');
        $infos = json_decode(file_get_contents('http://www.youtube.com/oembed?url='.$url.'&format=json'));

        $title = $request->request->get('title');
        $author = $infos->author_name;

        $embed_code = $infos->html;

        parse_str(parse_url($url, PHP_URL_QUERY)); // $v = l'id de la video
        $youtubeAPiInfos = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id='.$v.'&key=AIzaSyDyuaEAiMbpH9WCMOKKZjHjfvev_1aRlzs'));
        $dur = $youtubeAPiInfos->items[0]->contentDetails->duration;
        $dura = new \DateInterval($dur);
        $duration = $this->reverse($dura->format('%i:%s'));

        $playlistId = $request->request->get('playlist_id');
        $playlist = $em->getRepository('AppBundle:Playlist')->find($playlistId);

        $video = new Video();
        $video->setTItle($title);
        $video->setAuthor($author);
        $video->setDuration($duration);
        $video->setEmbedCode($embed_code);
        $video->setPlaylist($playlist);
        $em->persist($video);
        $em->flush();

        return new Response('Vidéo "'.$title.'" ('.$infos->provider_name.') bien ajoutée à la playlist '.$playlist->getTitle().' !', 200, array('Content-Type' => 'text/html'));
    }

    /**
     * @Route("/delete-video/{id}", name="app_admin_delete_video")
     * @Method("GET")
     */
    public function deleteVideoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $video = $em->getRepository('AppBundle:Video')->find($id);
            $em->remove($video);
            $em->flush();
        } else {
            throw $this->createAccessDeniedException("Ce que vous voulez voir n'est pas accessible.");
        }

        return new Response('Playlist "'.$video->getTitle().'" bien supprimée !');
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
            throw $this->createAccessDeniedException("Ce que vous voulez voir n'est pas accessible.");
        }

    }

    /**
     * @Route("/create-playlist", name="app_admin_create_playlist")
     * @Method("POST")
     */
    public function createPlaylist(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $playlist = new Playlist();
            $title = $request->request->get('title');
            $playlist->setTitle($title);
            $em->persist($playlist);
            $em->flush();

            return new Response('Playlist "'.$title.'" bien créée !');
        } else {
            throw $this->createAccessDeniedException("Ce que vous voulez faire n'est pas possible.");
        }
    }

    /**
     * @Route("/delete-playlist/{id}", name="app_admin_delete_playlist")
     * @Method("GET")
     */
    public function deletePlaylist(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $playlist = $em->getRepository('AppBundle:Playlist')->find($id);
            $em->remove($playlist);
            $em->flush();

            return new Response('Playlist "'.$playlist->getTitle().'" bien supprimée !');
        } else {
            throw $this->createAccessDeniedException("Ce que vous voulez faire n'est pas possible.");
        }
    }

    private function reverse($secs)
    {
        list($i, $s) = explode(':', $secs);

        return $i*60 + $s;
    }
}
