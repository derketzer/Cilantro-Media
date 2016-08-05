<?php

namespace Cilantro\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * YoutubeChannel
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class YoutubeChannel
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
     * @ORM\Column(name="channelId", type="string", length=255, unique=true)
     */
    private $channelId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishedAt", type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\OneToMany(targetEntity="YoutubeVideo", mappedBy="youtubeChannel")
     * @ORM\OrderBy({"publishedAt" = "desc"})
     */
    private $videos;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="adult", type="boolean")
     */
    private $adult;

    public function __construct() {
        $this->videos = new ArrayCollection();
    }

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
     * Set channelId
     *
     * @param string $channelId
     *
     * @return YoutubeChannel
     */
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * Get channelId
     *
     * @return string
     */
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return YoutubeChannel
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
     * Set description
     *
     * @param string $description
     *
     * @return YoutubeChannel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     *
     * @return YoutubeChannel
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return YoutubeChannel
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add video
     *
     * @param \Cilantro\AdminBundle\Entity\YoutubeVideo $video
     *
     * @return YoutubeChannel
     */
    public function addVideo(\Cilantro\AdminBundle\Entity\YoutubeVideo $video)
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \Cilantro\AdminBundle\Entity\YoutubeVideo $video
     */
    public function removeVideo(\Cilantro\AdminBundle\Entity\YoutubeVideo $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getAdult()
    {
        return $this->adult;
    }

    /**
     * @param int $adult
     */
    public function setAdult($adult)
    {
        $this->adult = $adult;
    }
}
