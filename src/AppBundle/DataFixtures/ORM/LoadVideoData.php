<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Video;

class LoadVideoData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $video = new Video;
        $video->setTItle('Un bébé chat joue du piano');
        $video->setAuthor('Pimolo10');
        $video->setDuration(110);
        $video->setEmbedCode('<iframe width="560" height="315" src="https://www.youtube.com/embed/WIgCmlPp25g" frameborder="0" allowfullscreen></iframe>');

        $manager->persist($video);
        $manager->flush();
    }
}
