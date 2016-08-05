<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{
    /**
     * @Route("/login")
     */
    public function loginAction()
    {
        return $this->render(':CilantroAdmin:login.html.twig');
    }

    /**
     * @Route("/")
     */
    public function dashboardAction()
    {
        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
                        ['title'=>'Dashboard']
        ];

        $breadcrumbsHtml = $this->generateBreadcrumbs($breadcrumbs);

        return $this->render('@CilantroAdmin/dashboard.html.twig', ['contentTitle'=>'Dashboard',
                                                          'breadcrumbs'=>$breadcrumbsHtml]);
    }

    private function generateBreadcrumbs($breadcrumbs=Array())
    {
        $breadcrumbsTemp = '';
        foreach ($breadcrumbs as $key=>$breadcrumb){
            if($key == 0){
                $breadcrumbsTemp .= '
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="'.$this->generateUrl($breadcrumb['path']).'">'.$breadcrumb['title'].'</a>
                    </li>
                ';
            }else if($key == count($breadcrumbs)-1){
                $breadcrumbsTemp .= '
                    <li class="active">
                        '.$breadcrumb['title'].'
                    </li>
                ';
            }else{
                $breadcrumbsTemp .= '
                    <li>
                        <a href="'.$this->generateUrl($breadcrumb['path']).'">'.$breadcrumb['title'].'</a>
                    </li>
                ';
            }
        }

        return $breadcrumbsTemp;
    }
}
