<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class YoutubeController extends Controller
{
    /**
     * @Route("/youtube/channel/{slug}/videos")
     */
    public function channelAction($slug='')
    {
        if(empty($slug))
            $this->redirectToRoute('cilantro_admin_index_dashboard');

        $youtubeChannelRespository = $this->getDoctrine()->getRepository('CilantroAdminBundle:YoutubeChannel');
        $youtubeChannel= $youtubeChannelRespository->findOneBy(array('slug' => $slug));

        if(empty($youtubeChannel))
            $this->redirectToRoute('cilantro_admin_index_dashboard');

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
}
