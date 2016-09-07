<?php

namespace Cilantro\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * YoutubeVideo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cilantro\AdminBundle\Repository\YoutubeVideoRepository")
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
     * @ORM\ManyToOne(targetEntity="YoutubeVideoArtist", inversedBy="videos")
     * @ORM\JoinColumn(name="youtube_video_artist_id", referencedColumnName="id")
     **/
    private $artist;

    /**
     * @ORM\ManyToOne(targetEntity="YoutubeVideoCategory", inversedBy="videos")
     * @ORM\JoinColumn(name="youtube_video_category_id", referencedColumnName="id")
     **/
    private $category;

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
     * @var integer
     *
     * @ORM\Column(name="font", type="boolean")
     */
    private $front;

    /**
     * @var integer
     *
     * @ORM\Column(name="season", type="integer", nullable=true)
     */
    private $season;

    /**
     * @var integer
     *
     * @ORM\Column(name="episode", type="integer", nullable=true)
     */
    private $episode;



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

    /**
     * @return mixed
     */
    public function getFront()
    {
        return $this->front;
    }

    /**
     * @param mixed $front
     */
    public function setFront($front)
    {
        $this->front = $front;
    }

    /**
     * @return mixed
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param mixed $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }

    /**
     * @return mixed
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    /**
     * @param mixed $episode
     */
    public function setEpisode($episode)
    {
        $this->episode = $episode;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}
