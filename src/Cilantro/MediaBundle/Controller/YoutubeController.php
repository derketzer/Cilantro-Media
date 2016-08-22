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
            $this->redirectToRoute('cilantro_media_home_index');

        $youtubeChannelRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeChannel');
        $youtubeChannel= $youtubeChannelRespository->findOneBy(array('slug' => $slug));

        $themePath = 'bundles/cilantromedia/site-assets/css/theme-color.css';
        if(file_exists('bundles/cilantromedia/css/site/theme-color-'.$slug.'.css'))
            $themePath = 'bundles/cilantromedia/css/site/theme-color-'.$slug.'.css';

        $disclaimer = $youtubeChannel->getAdult();

        $youtubeVideoRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeVideo');
        $popularVideos = $youtubeVideoRespository->findBy(Array('youtubeChannel'=>$youtubeChannel), Array('publishedAt'=>'DESC'), 5);
        $latestVideos = $youtubeVideoRespository->findBy(Array('youtubeChannel'=>$youtubeChannel), Array('publishedAt'=>'DESC'), 5);

        return $this->render('CilantroMediaBundle:Youtube:episode_list.html.twig', [
            'themePath' => $themePath,
            'disclaimer' => $disclaimer,
            'popular' => $popularVideos,
            'latest' => $latestVideos
        ]);
    }

    /**
     * @Route("/yt-channel/episode/{slug}")
     */
    public function episodeAction($slug='')
    {
        if(empty($slug))
            $this->redirectToRoute('cilantro_media_home_index');

        $youtubeVideoRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeVideo');
        $video = $youtubeVideoRespository->findOneBy(Array('id'=>$slug));

        if(empty($video))
            $this->redirectToRoute('cilantro_media_home_index');

        $vidIds = $youtubeVideoRespository->findBy(Array('youtubeChannel'=>$video->getYoutubeChannel()));
        shuffle($vidIds);
        $vidIds = array_slice($vidIds, 0, 8);

        $randomVideos = $youtubeVideoRespository->createQueryBuilder('v')
            ->select('v')
            ->where('v.id IN (:ids)')
            ->setParameter('ids', $vidIds)
            ->getQuery()
            ->getResult();

        $latestVideos = $youtubeVideoRespository->findBy(Array('youtubeChannel'=>$video->getYoutubeChannel()), Array('publishedAt'=>'DESC'), 5);

        $themePath = 'bundles/cilantromedia/site-assets/css/theme-color.css';
        if(file_exists('bundles/cilantromedia/css/site/theme-color-'.$slug.'.css'))
            $themePath = 'bundles/cilantromedia/css/site/theme-color-'.$slug.'.css';

        return $this->render('CilantroMediaBundle:Youtube:episode.html.twig', [
            'themePath' => $themePath,
            'videosRelacionados' => 1,
            'video' => $video,
            'random' => $randomVideos,
            'latest' => $latestVideos
        ]);
    }
}
