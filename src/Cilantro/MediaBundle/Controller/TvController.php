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
        return $this->render('CilantroMediaBundle:Tv:episode_list.html.twig');
    }
}
