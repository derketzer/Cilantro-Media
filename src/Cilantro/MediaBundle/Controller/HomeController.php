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

    /**
     * @Route("/aviso-legal")
     */
    public function avisoLegalAction()
    {
        return $this->render('CilantroMediaBundle::aviso_legal.html.twig');
    }

    /**
     * @Route("/vision")
     */
    public function visionAction()
    {
        return $this->render('CilantroMediaBundle::vision.html.twig');
    }

    /**
     * @Route("/nosotros")
     */
    public function nosotrosAction()
    {
        return $this->render('CilantroMediaBundle::nosotros.html.twig');
    }

    /**
     * @Route("/codigo-de-etica")
     */
    public function eticaAction()
    {
        return $this->render('CilantroMediaBundle::etica.html.twig');
    }
}
