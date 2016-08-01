<?php

namespace Cilantro\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * YoutubeStats
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class YoutubeStats
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
     * @var integer
     *
     * @ORM\Column(name="viewCount", type="integer")
     */
    private $viewCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="likeCount", type="integer")
     */
    private $likeCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="dislikeCount", type="integer")
     */
    private $dislikeCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="favoriteCount", type="integer")
     */
    private $favoriteCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="commentCount", type="integer")
     */
    private $commentCount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;


    /**
     * @ORM\OneToOne(targetEntity="YoutubeVideo", inversedBy="stats")
     * @ORM\JoinColumn(name="youtube_video_id", referencedColumnName="id")
     **/
    private $youtubeVideo;

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
     * Set viewCount
     *
     * @param integer $viewCount
     *
     * @return YoutubeStats
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * Get viewCount
     *
     * @return integer
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * Set likeCount
     *
     * @param integer $likeCount
     *
     * @return YoutubeStats
     */
    public function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    /**
     * Get likeCount
     *
     * @return integer
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * Set dislikeCount
     *
     * @param integer $dislikeCount
     *
     * @return YoutubeStats
     */
    public function setDislikeCount($dislikeCount)
    {
        $this->dislikeCount = $dislikeCount;

        return $this;
    }

    /**
     * Get dislikeCount
     *
     * @return integer
     */
    public function getDislikeCount()
    {
        return $this->dislikeCount;
    }

    /**
     * Set favoriteCount
     *
     * @param integer $favoriteCount
     *
     * @return YoutubeStats
     */
    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;

        return $this;
    }

    /**
     * Get favoriteCount
     *
     * @return integer
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * Set commentCount
     *
     * @param integer $commentCount
     *
     * @return YoutubeStats
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    /**
     * Get commentCount
     *
     * @return integer
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return YoutubeStats
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set youtubeVideo
     *
     * @param \Cilantro\AdminBundle\Entity\YoutubeVideo $youtubeVideo
     *
     * @return YoutubeStats
     */
    public function setYoutubeVideo(\Cilantro\AdminBundle\Entity\YoutubeVideo $youtubeVideo = null)
    {
        $this->youtubeVideo = $youtubeVideo;

        return $this;
    }

    /**
     * Get youtubeVideo
     *
     * @return \Cilantro\AdminBundle\Entity\YoutubeVideo
     */
    public function getYoutubeVideo()
    {
        return $this->youtubeVideo;
    }
}
