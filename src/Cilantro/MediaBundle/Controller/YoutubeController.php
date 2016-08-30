<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class YoutubeController extends Controller
{
    /**
     * @Route("/yt-channel/{slug}")
     */
    public function episodesAction($slug='')
    {
        if(empty($slug))
            return $this->redirectToRoute('cilantro_media_home_index');

        $youtubeChannelRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeChannel');
        $youtubeChannel= $youtubeChannelRespository->findOneBy(['slug' => $slug]);

        if(empty($youtubeChannel))
            return $this->redirectToRoute('cilantro_media_home_index');

        $themePath = 'bundles/cilantromedia/site-assets/css/theme-color.css';
        if(file_exists('bundles/cilantromedia/css/site/theme-color-'.$slug.'.css'))
            $themePath = 'bundles/cilantromedia/css/site/theme-color-'.$slug.'.css';

        $disclaimer = $youtubeChannel->getAdult();

        $youtubeVideoRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeVideo');

        $popularVideos = $youtubeVideoRespository->findBy(['youtubeChannel'=>$youtubeChannel]);
        usort($popularVideos, array($this, 'orderByStats'));
        $popularVideos = array_slice($popularVideos, 0, 5);

        $latestVideos = $youtubeVideoRespository->findBy(['youtubeChannel'=>$youtubeChannel], ['publishedAt'=>'DESC'], 5);

        $frontVideos = $youtubeVideoRespository->findBy(['youtubeChannel'=>$youtubeChannel, 'front'=>true], ['publishedAt'=>'DESC'], 5);

        $recommendedVideos = $youtubeVideoRespository->getOneByCategory();
        $episodes = $youtubeVideoRespository->getEpisodes();

        return $this->render('CilantroMediaBundle:Youtube:episode_list.html.twig', [
            'themePath' => $themePath,
            'disclaimer' => $disclaimer,
            'popular' => $popularVideos,
            'latest' => $latestVideos,
            'frontVideos' => $frontVideos,
            'channelSlug' => $slug,
            'recommendedVideos' => $recommendedVideos,
            'episodes' => $episodes
        ]);
    }

    /**
     * @Route("/yt-channel/episode/{slug}")
     */
    public function episodeAction($slug='')
    {
        if(empty($slug))
            return $this->redirectToRoute('cilantro_media_home_index');

        $youtubeVideoRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeVideo');
        $video = $youtubeVideoRespository->findOneBy(['slug'=>$slug]);

        if(empty($video))
            return $this->redirectToRoute('cilantro_media_home_index');

        $disclaimer = $video->getYoutubeChannel()->getAdult();

        $vidIds = $youtubeVideoRespository->findBy(['youtubeChannel'=>$video->getYoutubeChannel()]);
        shuffle($vidIds);
        $vidIds = array_slice($vidIds, 0, 8);

        $randomVideos = $youtubeVideoRespository->createQueryBuilder('v')
            ->select('v')
            ->where('v.id IN (:ids)')
            ->setParameter('ids', $vidIds)
            ->getQuery()
            ->getResult();

        $latestVideos = $youtubeVideoRespository->findBy(['youtubeChannel'=>$video->getYoutubeChannel()], ['publishedAt'=>'DESC'], 5);

        $moreVideos = $youtubeVideoRespository->findBy(['episode'=>$video->getEpisode()], ['publishedAt'=>'desc']);

        $themePath = 'bundles/cilantromedia/site-assets/css/theme-color.css';
        if(file_exists('bundles/cilantromedia/css/site/theme-color-'.$slug.'.css'))
            $themePath = 'bundles/cilantromedia/css/site/theme-color-'.$slug.'.css';

        return $this->render('CilantroMediaBundle:Youtube:episode.html.twig', [
            'themePath' => $themePath,
            'videosRelacionados' => 1,
            'disclaimer' => $disclaimer,
            'video' => $video,
            'random' => $randomVideos,
            'latest' => $latestVideos,
            'moreVideos' => $moreVideos
        ]);
    }

    private function orderByStats($a, $b)
    {
        if(empty($b->getStats()) || empty($a->getStats()))
            return 0;

        if($a->getStats()->getViewCount() == $b->getStats()->getViewCount()){
            return 0;
        }

        return ($a->getStats()->getViewCount() > $b->getStats()->getViewCount()) ? -1 : 1;
    }
}
