<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class ContactoController extends Controller
{
    /**
     * @Route("/contactos")
     */
    public function indexAction()
    {
        $contactoRepository = $this->getDoctrine()->getManager()->getRepository('CilantroAdminBundle:Contacto');
        $contactos = $contactoRepository->findBy([], ['createdAt'=>'desc']);

        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
            ['title'=>'Contacto']
        ];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        return $this->render('@CilantroAdmin/Contacto/list.html.twig', [
            'contentTitle'=>'Contacto',
            'breadcrumbs' => $breadcrumbsHtml,
            'contactos'=>$contactos]);
    }

    /**
     * @Route("/contacto/{contactoId}/delete")
     */
    public function deleteAction($contactoId)
    {
        if(empty($contactoId))
            return $this->redirectToRoute('cilantro_admin_contacto_index');

        $em = $this->getDoctrine()->getManager();

        $contactoRepository = $em->getRepository('CilantroAdminBundle:Contacto');
        $contacto = $contactoRepository->findOneBy(['id'=>$contactoId]);

        if(!empty($contacto)){
            $em->remove($contacto);
            $em->flush();
        }

        return $this->redirectToRoute('cilantro_admin_contacto_index');
    }
}
