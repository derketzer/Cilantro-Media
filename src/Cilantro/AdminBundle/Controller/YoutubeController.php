<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class YoutubeController extends Controller
{
    /**
     * @Route("/youtube/channel")
     */
    public function channelAction()
    {
        return new Response();
    }
}
