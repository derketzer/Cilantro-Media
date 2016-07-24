<?php

namespace Cilantro\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContactController extends Controller{
    /**
     * @Route("/contacto")
     */
    public function indexAction()
    {
        return $this->render('CilantroMediaBundle::contact.html.twig');
    }
}