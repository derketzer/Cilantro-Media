<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('CilantroMediaBundle:Home:home.html.twig');
    }

    /**
     * @Route("/politica-de-privacidad")
     */
    public function privacyAction()
    {
        return $this->render('CilantroMediaBundle::privacy.html.twig');
    }
}
