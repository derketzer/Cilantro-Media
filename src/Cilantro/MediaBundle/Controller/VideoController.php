<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class VideoController extends Controller
{
    /**
     * @Route("/videos")
     */
    public function videosAction()
    {

        $themePath = 'bundles/cilantromedia/site-assets/css/theme-color.css';

        $youtubeChannelRepository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeChannel');
        $youtubeVideoRepository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeVideo');

        $facebookVideoListRepository = $this->getDoctrine()->getRepository('CilantroAdminBundle:FacebookVideoList');
        $facebookVideoRepository = $this->getDoctrine()->getRepository('CilantroAdminBundle:FacebookVideo');

        $ytChannels = $youtubeChannelRepository->findBy(['active'=>true]);
        $fbLists = $facebookVideoListRepository->findBy(['active'=>true]);

        $videos = [];
        if(!empty($ytChannels)){
            foreach ($ytChannels as $ytChannel){
                $youtubeVideo = $youtubeVideoRepository->findBy(['youtubeChannel'=>$ytChannel], ['publishedAt'=>'desc'], 1);
                if(!empty($youtubeVideo)){
                    $videos[] = ['type'=>1, 'slug'=>$ytChannel->getSlug(), 'channelName'=>$ytChannel->getTitle(), 'video'=>$youtubeVideo[0]];
                }
            }
        }

        if(!empty($fbLists)){
            foreach ($fbLists as $fbList){
                $facbeookVideo = $facebookVideoRepository->findBy(['facebookVideoList'=>$fbList], ['publishedAt'=>'desc'], 1);
                if(!empty($facbeookVideo)){
                    $videos[] = ['type'=>2, 'slug'=>$fbList->getSlug(), 'channelName'=>$fbList->getTitle(), 'video'=>$facbeookVideo[0]];
                }
            }
        }

        return $this->render('CilantroMediaBundle:Home:videos.html.twig', [
            'themePath' => $themePath,
            'videos' => $videos
        ]);
    }
}
