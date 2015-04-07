<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VideoRepository")
 */
class Video
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="embed_code", type="text")
     */
    private $embedCode;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Playlist", inversedBy="videos")
     */
    private $playlist;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param  string $title
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param  string $author
     * @return Video
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set duration
     *
     * @param  integer $duration
     * @return Video
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set embedCode
     *
     * @param  string $embedCode
     * @return Video
     */
    public function setEmbedCode($embedCode)
    {
        $this->embedCode = $embedCode;

        return $this;
    }

    /**
     * Get embedCode
     *
     * @return string
     */
    public function getEmbedCode()
    {
        return $this->embedCode;
    }

    /**
     * Set playlist
     *
     * @param  \AppBundle\Entity\Playlist $playlist
     * @return Video
     */
    public function setPlaylist(\AppBundle\Entity\Playlist $playlist = null)
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * Get playlist
     *
     * @return \AppBundle\Entity\Playlist
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }
}
