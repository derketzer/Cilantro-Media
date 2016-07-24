<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TvController extends Controller
{
    /**
     * @Route("/tv/{slug}")
     */
    public function episodesAction($slug)
    {
        $themePath = 'bundles/cilantromedia/site-assets/css/theme-color.css';
        if(file_exists('bundles/cilantromedia/css/site/theme-color-'.$slug.'.css'))
            $themePath = 'bundles/cilantromedia/css/site/theme-color-'.$slug.'.css';

        return $this->render('CilantroMediaBundle:Tv:episode_list.html.twig', Array(
            'themePath' => $themePath
        ));
    }
}
