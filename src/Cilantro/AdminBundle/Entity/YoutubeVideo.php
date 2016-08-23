<?php

namespace Cilantro\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * YoutubeVideo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class YoutubeVideo
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
     * @ORM\Column(name="videoId", type="string", length=255, unique=true)
     */
    private $videoId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishedAt", type="datetime")
     */
    private $publishedAt;

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
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255)
     */
    private $thumbnail;

    /**
     * @ORM\ManyToOne(targetEntity="YoutubeChannel", inversedBy="videos")
     * @ORM\JoinColumn(name="youtube_channel_id", referencedColumnName="id")
     **/
    private $youtubeChannel;

    /**
     * @ORM\OneToOne(targetEntity="YoutubeStats", mappedBy="youtubeVideo")
     **/
    private $stats;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToMany(targetEntity="YoutubeVideoTag", inversedBy="videos")
     * @ORM\JoinTable(name="youtube_video_tags")
     */
    private $tags;

    public function __construct() {
        $this->tags = new ArrayCollection();
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
     * Set videoId
     *
     * @param string $videoId
     *
     * @return YoutubeVideo
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get videoId
     *
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     *
     * @return YoutubeVideo
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
     * Set title
     *
     * @param string $title
     *
     * @return YoutubeVideo
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
     * @return YoutubeVideo
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
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return YoutubeVideo
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return YoutubeVideo
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
     * Set youtubeChannel
     *
     * @param \Cilantro\AdminBundle\Entity\YoutubeChannel $youtubeChannel
     *
     * @return YoutubeVideo
     */
    public function setYoutubeChannel(\Cilantro\AdminBundle\Entity\YoutubeChannel $youtubeChannel = null)
    {
        $this->youtubeChannel = $youtubeChannel;

        return $this;
    }

    /**
     * Get youtubeChannel
     *
     * @return \Cilantro\AdminBundle\Entity\YoutubeChannel
     */
    public function getYoutubeChannel()
    {
        return $this->youtubeChannel;
    }

    /**
     * Set stats
     *
     * @param \Cilantro\AdminBundle\Entity\YoutubeStats $stats
     *
     * @return YoutubeVideo
     */
    public function setStats(\Cilantro\AdminBundle\Entity\YoutubeStats $stats = null)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Get stats
     *
     * @return \Cilantro\AdminBundle\Entity\YoutubeStats
     */
    public function getStats()
    {
        return $this->stats;
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
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function addTag($tag)
    {
        foreach ($this->tags as $tagTemp){
            if($tagTemp->getName() == $tag->getName()){
                return null;
            }
        }

        $this->tags[] = $tag;
    }

    public function flushTags()
    {
        $this->tags = [];
    }
}
