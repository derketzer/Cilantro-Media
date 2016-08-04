<?php

namespace Cilantro\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("login")
     */
    public function indexAction()
    {
        return $this->render('@CilantroAdmin/index.html.twig');
    }
}