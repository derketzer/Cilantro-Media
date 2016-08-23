<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class YoutubeController extends Controller
{
    /**
     * @Route("/youtube/channels")
     */
    public function channelsAction()
    {
        $youtubeChannelRepository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeChannel');
        $youtubeChannels = $youtubeChannelRepository->findAll();

        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
            ['title'=>'Youtube Channels']
        ];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        return $this->render('@CilantroAdmin/Youtube/channels.html.twig',
            ['contentTitle'=>'Youtube Channels',
            'breadcrumbs' => $breadcrumbsHtml,
            'youtubeChannels' => $youtubeChannels]);
    }

    /**
     * @Route("/youtube/channel/{slug}/videos")
     */
    public function channelAction($slug='')
    {
        if(empty($slug))
            return $this->redirectToRoute('cilantro_admin_index_dashboard');

        $youtubeChannelRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeChannel');
        $youtubeChannel = $youtubeChannelRespository->findOneBy(array('slug' => $slug));

        if(empty($youtubeChannel))
            return $this->redirectToRoute('cilantro_admin_index_dashboard');

        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
            ['title'=>'Youtube'],
            ['title'=>$youtubeChannel->getTitle()]
        ];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        $youtubeVideoRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeVideo');
        $videos = $youtubeVideoRespository->findBy(Array('youtubeChannel'=>$youtubeChannel), Array('publishedAt'=>'DESC'));

        return $this->render('@CilantroAdmin/Youtube/videos.html.twig', ['contentTitle'=>$youtubeChannel->getTitle(),
            'breadcrumbs' => $breadcrumbsHtml,
            'videos' => $videos]);
    }

    /**
     * @Route("/youtube/channel/active/switch")
     */
    public function channelSwitchActiveAction(Request $request)
    {
        $checkedValue = $request->request->get('checkedValue');
        $channelId = $request->request->get('channelId');

        if(empty($channelId)){
            return new Response(json_encode(['type'=>'error', 'text'=>'El canal está vacía!']));
        }

        $em = $this->getDoctrine()->getManager();
        $youtubeChannelRepository = $em->getRepository('CilantroAdminBundle:YoutubeChannel');
        $channel = $youtubeChannelRepository->findOneBy(['id'=>$channelId]);

        if(!empty($channel)){
            try {
                $channel->setActive($checkedValue);
                $em->persist($channel);
                $em->flush();
            }catch(\Exception $e){
                return new Response(json_encode(['type'=>'error', 'text'=>"Hubo un error al guardar el canal!\n\n".$e->getMessage()]));
            }
        }else{
            return new Response(json_encode(['type'=>'error', 'text'=>'El canal no existe!']));
        }

        return new Response(json_encode([]));
    }

    /**
     * @Route("/youtube/channel/adult/switch")
     */
    public function channelSwitchAdultAction(Request $request)
    {
        $checkedValue = $request->request->get('checkedValue');
        $channelId = $request->request->get('channelId');

        if(empty($channelId)){
            return new Response(json_encode(['type'=>'error', 'text'=>'El canal está vacío!']));
        }

        $em = $this->getDoctrine()->getManager();
        $youtubeChannelRepository = $em->getRepository('CilantroAdminBundle:YoutubeChannel');
        $channel = $youtubeChannelRepository->findOneBy(['id'=>$channelId]);

        if(!empty($channel)){
            try {
                $channel->setAdult($checkedValue);
                $em->persist($channel);
                $em->flush();
            }catch(\Exception $e){
                return new Response(json_encode(['type'=>'error', 'text'=>"Hubo un error al guardar el canal!\n\n".$e->getMessage()]));
            }
        }else{
            return new Response(json_encode(['type'=>'error', 'text'=>'El canal no existe!']));
        }

        return new Response(json_encode([]));
    }

    /**
     * @Route("/youtube/video/active/switch")
     */
    public function videoSwitchActiveAction(Request $request)
    {
        $checkedValue = $request->request->get('checkedValue');
        $videoId = $request->request->get('videoId');

        if(empty($videoId)){
            return new Response(json_encode(['type'=>'error', 'text'=>'El video está vacía!']));
        }

        $em = $this->getDoctrine()->getManager();
        $youtubeVideoRepository = $em->getRepository('CilantroAdminBundle:YoutubeVideo');
        $video = $youtubeVideoRepository->findOneBy(['id'=>$videoId]);

        if(!empty($video)){
            try {
                $video->setActive($checkedValue);
                $em->persist($video);
                $em->flush();
            }catch(\Exception $e){
                return new Response(json_encode(['type'=>'error', 'text'=>"Hubo un error al guardar el video!\n\n".$e->getMessage()]));
            }
        }else{
            return new Response(json_encode(['type'=>'error', 'text'=>'El video no existe!']));
        }

        return new Response(json_encode([]));
    }

    /**
     * @Route("/youtube/video/front/switch")
     */
    public function videoSwitchFrontAction(Request $request)
    {
        $checkedValue = $request->request->get('checkedValue');
        $videoId = $request->request->get('videoId');

        if(empty($videoId)){
            return new Response(json_encode(['type'=>'error', 'text'=>'El video está vacía!']));
        }

        $em = $this->getDoctrine()->getManager();
        $youtubeVideoRepository = $em->getRepository('CilantroAdminBundle:YoutubeVideo');
        $video = $youtubeVideoRepository->findOneBy(['id'=>$videoId]);

        if(!empty($video)){
            if($checkedValue) {
                $videosFronts = $youtubeVideoRepository->findBy(['front' => true]);
                if (!empty($videosFronts) && count($videosFronts) > 3) {
                    return new Response(json_encode(['type' => 'error', 'text' => "Ya hay 4 videos seleccionados para la portada!"]));
                }
            }

            try {
                $video->setFront($checkedValue);
                $em->persist($video);
                $em->flush();
            }catch(\Exception $e){
                return new Response(json_encode(['type'=>'error', 'text'=>"Hubo un error al guardar el video!\n\n".$e->getMessage()]));
            }
        }else{
            return new Response(json_encode(['type'=>'error', 'text'=>'El video no existe!']));
        }

        return new Response(json_encode([]));
    }
}
