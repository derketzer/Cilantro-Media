<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FacebookController extends Controller
{
    private $videoLimit = 6;

    /**
     * @Route("/fb-channel/{slug}/{page}")
     */
    public function episodesAction($slug, $page=1)
    {
        if(empty($slug))
            return $this->redirectToRoute('cilantro_media_home_index');

        $themePath = 'bundles/cilantromedia/site-assets/css/theme-color.css';
        if(file_exists('bundles/cilantromedia/css/site/theme-color-'.$slug.'.css'))
            $themePath = 'bundles/cilantromedia/css/site/theme-color-'.$slug.'.css';

        $videoListRepository = $this->getDoctrine()->getRepository('CilantroAdminBundle:FacebookVideoList');
        $videoList = $videoListRepository->findOneBy(['slug'=>$slug]);

        if(empty($videoList))
            return $this->redirectToRoute('cilantro_media_home_index');

        $videoRepository = $this->getDoctrine()->getRepository('CilantroAdminBundle:FacebookVideo');
        $videos = $videoRepository->findBy(['facebookVideoList'=>$videoList, 'published'=>true], ['facebookId'=>'desc'], $this->videoLimit, $page-1);

        $videosPopulares = $videoRepository->findBy(['facebookVideoList'=>$videoList, 'published'=>true], ['views'=>'desc'], 5);

        $allVideos = $videoRepository->findBy(['facebookVideoList'=>$videoList, 'published'=>true]);
        $pages = intval(ceil(count($allVideos)/$this->videoLimit));

        if(empty($videos))
            return $this->redirectToRoute('cilantro_media_home_index');

        return $this->render('@CilantroMedia/Facebook/episode_list.html.twig',[
            'themePath' => $themePath,
            'videoList' => $videoList,
            'videos' => $videos,
            'videosPopulares' => $videosPopulares,
            'pages' => $pages,
            'currentPage' => $page
        ]);
    }

    /**
     * @Route("/fb-channel/{listSlug}/episode/{videoSlug}")
     */
    public function episodeAction($listSlug, $videoSlug)
    {
        if(!empty($videoSlug)){
            $videoRepository = $this->getDoctrine()->getRepository('CilantroAdminBundle:FacebookVideo');
            $video = $videoRepository->findOneBy(['slug'=>$videoSlug]);

            if(empty($video))
                return $this->redirectToRoute('cilantro_media_facebook_episodes', ['slug'=>$listSlug]);

            return $this->render('@CilantroMedia/Facebook/episode.html.twig', ['content'=>$video->getEmbedHtml()]);
        }
    }
}
