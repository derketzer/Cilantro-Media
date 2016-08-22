<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FacebookController extends Controller
{
    /**
     * @Route("/fb-channel/{slug}")
     */
    public function episodesAction()
    {
        return $this->render('');
    }
}
