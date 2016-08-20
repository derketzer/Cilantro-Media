<?php

namespace Cilantro\AdminBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Google_Client;
use Google_Service_YouTube;
use Cilantro\AdminBundle\Entity\YoutubeChannel;
use Cilantro\AdminBundle\Entity\YoutubeVideo;
use Cilantro\AdminBundle\Entity\YoutubeStats;
use Symfony\Component\DependencyInjection\Container;

class YoutubeService
{
    private $em;
    private $container;
    private $googleClient;
    private $googleService;
    private $log;

    public function __construct(Doctrine $doctrine, Container $container)
    {
        $this->em = $doctrine->getManager();
        $this->container = $container;

        $this->googleClient = new Google_Client();
        $this->googleClient->setAuthConfig($this->container->get('kernel')->getRootDir().'/cilantromedia.json');
        $this->googleClient->setScopes(['https://www.googleapis.com/auth/youtube',
            'https://www.googleapis.com/auth/youtube.force-ssl',
            'https://www.googleapis.com/auth/youtube.readonly',
            'https://www.googleapis.com/auth/youtubepartner']);

        $this->googleClient->setApplicationName('Cilantro Media');

        $this->googleService = new Google_Service_YouTube($this->googleClient);

        $this->log = new LogService($container);
        $this->log->init();
    }

    public function channel()
    {
        $channels = $this->googleService->channels->listChannels('snippet', array('id'=>'UCPAYAZIOoMD-4A3-3Hr_4wQ'));

        $youtubeChannelRespository = $this->em->getRepository('CilantroAdminBundle:YoutubeChannel');

        if(!empty($channels)) {
            foreach ($channels->getItems() as $item) {
                $youtubeChannelTemp = $youtubeChannelRespository->findBy(array('channelId' => $item->id));

                if (empty($youtubeChannelTemp)) {
                    $youtubeChannel = new YoutubeChannel();
                    $youtubeChannel->setChannelId($item->id);
                    $youtubeChannel->setTitle($item->getSnippet()->title);
                    $youtubeChannel->setDescription($item->getSnippet()->description);
                    $youtubeChannel->setPublishedAt(new \DateTime($item->getSnippet()->publishedAt));
                    $youtubeChannel->setActive(true);

                    try {
                        $this->em->persist($youtubeChannel);
                        $this->em->flush();
                    } catch (\Exception $e) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function video()
    {
        $youtubeChannelRespository = $this->em->getRepository('CilantroAdminBundle:YoutubeChannel');
        $youtubeVideoRespository = $this->em->getRepository('CilantroAdminBundle:YoutubeVideo');

        $youtubeChannels = $youtubeChannelRespository->findBy(Array('active'=>true));

        if(!empty($youtubeChannels)) {
            $videosAgregados = 0;

            foreach ($youtubeChannels as $youtubeChannel) {
                $lastVideo = $youtubeVideoRespository->findBy(Array('youtubeChannel'=>$youtubeChannel), Array('publishedAt' => 'DESC'), 1);
                if (empty($lastVideo)) {
                    $videos = $this->googleService->search->listSearch('snippet,id', array('order' => 'date', 'maxResults' => '50', 'channelId' => $youtubeChannel->getChannelId()));
                } else {
                    $lastVideoDate = date("Y-m-d\T00:00:00\Z", $lastVideo[0]->getPublishedAt()->getTimestamp());
                    $videos = $this->googleService->search->listSearch('snippet,id', array('order' => 'date', 'maxResults' => '50', 'channelId' => $youtubeChannel->getChannelId(), 'publishedAfter' => $lastVideoDate));
                }

                do {
                    foreach ($videos->getItems() as $item) {
                        if (!isset($item->getId()->videoId))
                            continue;

                        $youtubeVideoTemp = $youtubeVideoRespository->findBy(array('videoId' => $item->getId()->videoId));

                        if (empty($youtubeVideoTemp)) {
                            $youtubeVideo = new YoutubeVideo();
                            $youtubeVideo->setVideoId($item->getId()->videoId);
                            $youtubeVideo->setTitle($item->getSnippet()->title);
                            $youtubeVideo->setDescription($item->getSnippet()->description);
                            $youtubeVideo->setThumbnail($item->getSnippet()->getThumbnails()->high->url);
                            $youtubeVideo->setPublishedAt(new \DateTime($item->getSnippet()->publishedAt));
                            $youtubeVideo->setYoutubeChannel($youtubeChannel);
                            $youtubeVideo->setActive(true);

                            try {
                                $this->em->persist($youtubeVideo);
                                $this->em->flush();
                                $videosAgregados++;
                            } catch (\Exception $e) {
                                $this->log->errorMessage('Youtube: Video save Error!');
                                return false;
                            }
                        }
                    }
                    $nextPageToken = $videos->nextPageToken;
                    if (!empty($nextPageToken)) {
                        $videos = $this->googleService->search->listSearch('snippet,id', array('order' => 'date', 'pageToken' => $nextPageToken, 'maxResults' => '50', 'channelId' => $youtubeChannel->getChannelId()));
                    }
                } while (!empty($nextPageToken));
            }
        }

        $this->log->infoMessage('Youtube: '.$videosAgregados.' new videos added.');

        return true;
    }

    public function stats($count="")
    {
        $youtubeVideoRespository = $this->em->getRepository('CilantroAdminBundle:YoutubeVideo');
        $youtubeStatsRespository = $this->em->getRepository('CilantroAdminBundle:YoutubeStats');

        if($count == 0) {
            $youtubeVideos = $youtubeVideoRespository->findBy(Array('active' => true), Array('publishedAt'=>'DESC'));
            $logMessage = 'Youtube: All videos stats updated.';
        }else if($count != "") {
            $youtubeVideos = $youtubeVideoRespository->findBy(Array('active' => true), Array('publishedAt'=>'DESC'), $count);
            $logMessage = 'Youtube: Last '.$count.' videos stats updated.';
        }else{
            $youtubeVideos = $youtubeVideoRespository->findBy(Array('active' => true), Array('publishedAt'=>'DESC'), 30);
            $logMessage = 'Youtube: Last 30 videos stats updated.';
        }

        if(!empty($youtubeVideos)) {
            foreach ($youtubeVideos as $youtubeVideo) {
                $videos = $this->googleService->videos->listVideos('statistics', array('id' => $youtubeVideo->getVideoId()));

                foreach ($videos->getItems() as $item) {
                    $youtubeStats = $youtubeStatsRespository->findOneBy(array('youtubeVideo' => $youtubeVideo->getId()));

                    if (empty($youtubeStats)) {
                        $youtubeStats = new YoutubeStats();
                        $youtubeStats->setYoutubeVideo($youtubeVideo);
                        $youtubeStats->setCommentCount($item->getStatistics()->commentCount);
                        $youtubeStats->setDislikeCount($item->getStatistics()->dislikeCount);
                        $youtubeStats->setFavoriteCount($item->getStatistics()->favoriteCount);
                        $youtubeStats->setLikeCount($item->getStatistics()->likeCount);
                        $youtubeStats->setViewCount($item->getStatistics()->viewCount);
                        $youtubeStats->setUpdatedAt(new \DateTime());
                    } else {
                        $youtubeStats->setCommentCount($item->getStatistics()->commentCount);
                        $youtubeStats->setDislikeCount($item->getStatistics()->dislikeCount);
                        $youtubeStats->setFavoriteCount($item->getStatistics()->favoriteCount);
                        $youtubeStats->setLikeCount($item->getStatistics()->likeCount);
                        $youtubeStats->setViewCount($item->getStatistics()->viewCount);
                        $youtubeStats->setUpdatedAt(new \DateTime());
                    }

                    try {
                        $this->em->persist($youtubeStats);
                        $this->em->flush();
                    } catch (\Exception $e) {
                        $this->log->errorMessage('Youtube: Stats save Error!');
                        return false;
                    }
                }
            }
        }

        $this->log->infoMessage($logMessage);

        return true;
    }
}