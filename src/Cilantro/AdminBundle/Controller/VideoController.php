<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    /**
     * @Route("/videos/facebook/lists")
     */
    public function facebookListAction()
    {
        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
            ['title'=>'Facebook Video List']
        ];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        $videoListsRepository = $this->getDoctrine()->getManager()->getRepository('CilantroAdminBundle:FacebookVideoList');
        $videoLists = $videoListsRepository->findAll();

        return $this->render('@CilantroAdmin/Video/list.html.twig', ['contentTitle'=>'Video Lists',
            'breadcrumbs'=>$breadcrumbsHtml,
            'videoLists'=>$videoLists]);
    }

    /**
     * @Route("/videos/facebook/list/{facebookId}/videos")
     */
    public function facebookListVideosAction($facebookId)
    {
        $videoListsRepository = $this->getDoctrine()->getManager()->getRepository('CilantroAdminBundle:FacebookVideoList');
        $videoList = $videoListsRepository->findOneBy(['facebookId'=>$facebookId]);

        $videosRepository = $this->getDoctrine()->getManager()->getRepository('CilantroAdminBundle:FacebookVideo');
        $videos = $videosRepository->findBy(['facebookVideoList'=>$videoList]);

        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
            ['title'=>'Facebook Video List', 'path'=>'cilantro_admin_video_facebooklist'],
            ['title'=>$videoList->getTitle()]
        ];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        return $this->render('@CilantroAdmin/Video/video_list.html.twig', ['contentTitle'=>'Lista "'.$videoList->getTitle().'"',
            'breadcrumbs'=>$breadcrumbsHtml,
            'videos'=>$videos]);
    }

    /**
     * @Route("/videos/facebook/list/active/switch")
     */
    public function facebookListSwitchAction(Request $request)
    {
        $checkedValue = $request->request->get('checkedValue');
        $videoListId = $request->request->get('videoListId');

        if(empty($videoListId)){
            return new Response(json_encode(['type'=>'error', 'text'=>'La lista está vacía!']));
        }

        $em = $this->getDoctrine()->getManager();
        $videoListsRepository = $em->getRepository('CilantroAdminBundle:FacebookVideoList');
        $videoList = $videoListsRepository->findOneBy(['id'=>$videoListId]);

        if(!empty($videoList)){
            try {
                $videoList->setActive($checkedValue);
                $em->persist($videoList);
                $em->flush();
            }catch(\Exception $e){
                return new Response(json_encode(['type'=>'error', 'text'=>"Hubo un error al guardar la lista!\n\n".$e->getMessage()]));
            }
        }else{
            return new Response(json_encode(['type'=>'error', 'text'=>'La lista no existe!']));
        }

        return new Response(json_encode([]));
    }
}
