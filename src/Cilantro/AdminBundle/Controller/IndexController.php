<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{
    /**
     * @Route("/")
     */
    public function dashboardAction()
    {
        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
                        ['title'=>'Dashboard']
        ];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        return $this->render('@CilantroAdmin/dashboard.html.twig', ['contentTitle'=>'Dashboard',
                                                          'breadcrumbs'=>$breadcrumbsHtml]);
    }
}
