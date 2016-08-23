<?php

namespace Cilantro\MediaBundle\Controller;

use Cilantro\AdminBundle\Entity\Contacto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller{
    /**
     * @Route("/contacto")
     */
    public function indexAction()
    {
        return $this->render('CilantroMediaBundle::contact.html.twig');
    }

    /**
     * @Route("/contacto/send")
     */
    public function sendAction(Request $request)
    {
        $data = $request->request->all();

        $contact = new Contacto();
        $contact->setName($data['userName']);
        $contact->setEmail($data['userEmail']);
        $contact->setCreatedAt(new \DateTime());
        $contact->setMessage($data['userMessage']);
        $contact->setSubject($data['userSubject']);
        $contact->setTelephone($data['userTelephone']);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush($contact);

            $response = ['type'=>'exito', 'text'=>'Gracias por sus comentarios.'];
        }catch(\Exception $e){
            $response = ['type'=>'error', 'text'=>'Hubo un error al enviarse el formulario'];
        }

        return new Response(json_encode($response), 200);
    }
}