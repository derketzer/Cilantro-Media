<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FacebookController extends Controller
{
    private $videoLimit = 5;

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

        $allVideos = $videoRepository->findBy(['facebookVideoList'=>$videoList, 'published'=>true]);
        $pages = intval(ceil(count($allVideos)/$this->videoLimit));

        if(empty($videos))
            return $this->redirectToRoute('cilantro_media_home_index');

        return $this->render('@CilantroMedia/Facebook/episode_list.html.twig',[
            'themePath' => $themePath,
            'videoList' => $videoList,
            'videos' => $videos,
            'pages' => $pages,
            'currentPage' => $page
        ]);
    }
}
