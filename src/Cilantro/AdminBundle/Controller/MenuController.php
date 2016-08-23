<?php

namespace Cilantro\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    /**
     * @Route("/menus");
     */
    public function indexAction()
    {
        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
            ['title'=>'Menu']
        ];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        $menuRepository = $this->getDoctrine()->getManager()->getRepository('CilantroMediaBundle:Menu');
        $menus = $menuRepository->findBy([], ['parent'=>'asc', 'order'=>'asc']);

        $parentMenus = $menuRepository->findBy(['parent'=>null], ['name'=>'asc']);

        return $this->render('@CilantroAdmin/Menu/list.html.twig', [
            'menus'=>$menus,
            'parentMenus'=>$parentMenus,
            'contentTitle'=>'Menu',
            'breadcrumbs' => $breadcrumbsHtml
        ]);
    }

    /**
     * @Route("/menu/active/switch")
     */
    public function menuSwitchActiveAction(Request $request)
    {
        $checkedValue = $request->request->get('checkedValue');
        $menuId = $request->request->get('menuId');

        if(empty($menuId)){
            return new Response(json_encode(['type'=>'error', 'text'=>'El menú está vacío!']));
        }

        $em = $this->getDoctrine()->getManager();
        $menuRepository = $em->getRepository('CilantroMediaBundle:Menu');
        $menu = $menuRepository->findOneBy(['id'=>$menuId]);

        if(!empty($menu)){
            try {
                $menu->setActive($checkedValue);
                $em->persist($menu);
                $em->flush();
            }catch(\Exception $e){
                return new Response(json_encode(['type'=>'error', 'text'=>"Hubo un error al guardar el menú!\n\n".$e->getMessage()]));
            }
        }else{
            return new Response(json_encode(['type'=>'error', 'text'=>'El menú no existe!']));
        }

        return new Response(json_encode([]));
    }

    /**
     * @Route("/menu/parent/switch")
     */
    public function menuParentSwitchAction(Request $request)
    {
        $menuParentId = $request->request->get('menuParentId');
        $menuId = $request->request->get('menuId');

        if(empty($menuId)){
            return new Response(json_encode(['type'=>'error', 'text'=>'El menú está vacío!']));
        }

        $em = $this->getDoctrine()->getManager();
        $menuRepository = $em->getRepository('CilantroMediaBundle:Menu');
        $menu = $menuRepository->findOneBy(['id'=>$menuId]);
        $menuParent = $menuRepository->findOneBy(['id'=>$menuParentId]);

        if(!empty($menu)){
            try {
                $menu->setParent($menuParent);
                $em->persist($menu);
                $em->flush();
            }catch(\Exception $e){
                return new Response(json_encode(['type'=>'error', 'text'=>"Hubo un error al guardar el menú!\n\n".$e->getMessage()]));
            }
        }else{
            return new Response(json_encode(['type'=>'error', 'text'=>'El menú no existe!']));
        }

        return new Response(json_encode([]));
    }
}
