<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sunra\PhpSimple\HtmlDomParser;

class MainController extends Controller
{
    /**
     * @Route("/", name="app_front_accueil")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/get-current-video", name="bite")
     */
    public function getCurrentVideo()
    {
        $videoRepo = $this->getDoctrine()->getRepository('AppBundle:Video');
        $query = $videoRepo->createQueryBuilder('v')
            ->where('v.beginningDate < :now')
            ->orderBy('v.beginningDate', 'DESC')
            ->setParameter('now', new \DateTime())
            ->setMaxResults(1)
            ->getQuery()
        ;
        $currentVideo = $query->getOneOrNullResult();

        $iframeParsed = HtmlDomParser::str_get_html($currentVideo->getEmbedCode())->find('iframe', 0);
        $iframeParsed->src .= '&autoplay=1';
        $iframeParsed->width = '100%';
        $iframeParsed->height = '1080';
        $iframeParsed->frameborder = '0';

        return new Response($iframeParsed);
    }

    /**
     * @Route("/get-next-video", name="bite_bite")
     */
    public function getNextVideo()
    {
        $videoRepo = $this->getDoctrine()->getRepository('AppBundle:Video');
        $query = $videoRepo->createQueryBuilder('v')
            ->where('v.beginningDate > :now')
            ->orderBy('v.beginningDate', 'ASC')
            ->setParameter('now', new \DateTime())
            ->setMaxResults(1)
            ->getQuery()
        ;
        $currentVideo = $query->getOneOrNullResult();

        $iframeParsed = HtmlDomParser::str_get_html($currentVideo->getEmbedCode())->find('iframe', 0);
        $iframeParsed->src .= '&autoplay=1';
        $iframeParsed->width = '100%';
        $iframeParsed->height = '1080';
        $iframeParsed->frameborder = '0';

        return new Response($iframeParsed);
    }
}
