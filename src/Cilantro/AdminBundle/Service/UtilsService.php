<?php

namespace Cilantro\AdminBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class UtilsService
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function generateBreadcrumbs($breadcrumbs=Array())
    {
        if(empty($breadcrumbs))
            return '';

        $breadcrumbsTemp = '';
        foreach ($breadcrumbs as $key=>$breadcrumb){
            if($key == 0){
                $breadcrumbsTemp .= '
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                ';

                if(isset($breadcrumb['path'])) {
                    $breadcrumbsTemp .= '
                        <a href="' . $this->container->get('router')->generate($breadcrumb['path']) . '">
                    ';
                }

                $breadcrumbsTemp .= $breadcrumb['title'];

                if(isset($breadcrumb['path'])) {
                    $breadcrumbsTemp .= '
                        </a>
                    ';
                }
                $breadcrumbsTemp .= '
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
                ';

                if(isset($breadcrumb['path'])) {
                    $breadcrumbsTemp .= '
                        <a href="' . $this->container->get('router')->generate($breadcrumb['path']) . '">
                    ';
                }

                $breadcrumbsTemp .= $breadcrumb['title'];

                if(isset($breadcrumb['path'])) {
                    $breadcrumbsTemp .= '
                        </a>
                    ';
                }
                $breadcrumbsTemp .= '
                    </li>
                ';
            }
        }

        return $breadcrumbsTemp;
    }
}