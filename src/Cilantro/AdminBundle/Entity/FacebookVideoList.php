<?php

namespace Cilantro\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FacebookVideoList
 *
 * @ORM\Table(name="facebook_video_list")
 * @ORM\Entity(repositoryClass="Cilantro\AdminBundle\Repository\FacebookVideoListRepository")
 */
class FacebookVideoList
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="facebookId", type="string", length=50, unique=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="FacebookPage", inversedBy="videoLists")
     * @ORM\JoinColumn(name="facebook_page_id", referencedColumnName="id")
     **/
    private $facebookPage;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="FacebookVideo", mappedBy="facebookVideoList")
     */
    private $videos;

    public function __construct() {
        $this->videos = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param int $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return FacebookVideoList
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
     * @return mixed
     */
    public function getFacebookPage()
    {
        return $this->facebookPage;
    }

    /**
     * @param mixed $facebookPage
     */
    public function setFacebookPage($facebookPage)
    {
        $this->facebookPage = $facebookPage;
    }

    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
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
}

