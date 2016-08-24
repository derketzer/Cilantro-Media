<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends Controller
{
    /**
     * @Route("/produccion-y-contenido")
     */
    public function produccionAction()
    {
        return $this->render('@CilantroMedia/Service/produccion.html.twig');
    }

    /**
     * @Route("/renta-de-foros-y-cabinas")
     */
    public function rentaAction()
    {
        return $this->render('@CilantroMedia/Service/renta.html.twig');
    }

    /**
     * @Route("/tv-online")
     */
    public function tvOnlineAction()
    {
        return $this->render('@CilantroMedia/Service/tv_online.html.twig');
    }
}
