<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
}
