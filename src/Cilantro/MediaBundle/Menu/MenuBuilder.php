<?php

namespace Cilantro\MediaBundle\Menu;

use Knp\Menu\FactoryInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;
    private $em;

    public function __construct(FactoryInterface $factory, Doctrine $doctrine)
    {
        $this->factory = $factory;
        $this->em = $doctrine->getManager();
    }

    public function createMainMenu(Array $options)
    {
        $menu = $this->factory->createItem('root')->setChildrenAttribute('class', 'nav navbar-nav');

        $menuRepository = $this->em->getRepository('CilantroMediaBundle:Menu');
        $menusTemp = $menuRepository->findBy(['parent'=>NULL, 'active'=>true], ['order'=>'asc']);

        foreach($menusTemp as $menuTemp){
            if($menuTemp->getPath() == NULL){
                $subMenu = $menu->addChild($menuTemp->getName(), ['uri'=>'#']);
            }else{
                if($menu->getAttributes() != "") {
                    $subMenu = $menu->addChild($menuTemp->getName(), [
                        'route' => $menuTemp->getPath(),
                        'routeParameters' => json_decode($menuTemp->getAttributes(), true)
                    ]);
                }else{
                    $subMenu = $menu->addChild($menuTemp->getName(), ['route' => $menuTemp->getPath()]);
                }
            }

            $subMenusTemp = $menuRepository->findBy(['parent'=>$menuTemp, 'active'=>true], ['order'=>'asc']);
            if(!empty($subMenusTemp)) {
                $subMenu->setAttribute('class', 'dropdown');
                $subMenu->setLinkAttributes(['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']);
                $subMenu->setChildrenAttribute('class', 'dropdown-menu');

                foreach ($subMenusTemp as $subMenuTemp) {
                    $subMenu->addChild($subMenuTemp->getName()  , [
                        'route' => $subMenuTemp->getPath(),
                        'routeParameters' => json_decode($subMenuTemp->getAttributes(), true)
                    ]);
                }
            }
        }

        return $menu;
    }

    public function createSiteMenu(Array $options)
    {
        $menu = $this->factory->createItem('root')->setChildrenAttribute('class', 'main-menu');

        $menuRepository = $this->em->getRepository('CilantroMediaBundle:Menu');
        $menusTemp = $menuRepository->findBy(['parent'=>NULL, 'active'=>true], ['order'=>'asc']);

        foreach($menusTemp as $menuTemp){
            if($menuTemp->getPath() == NULL){
                $subMenu = $menu->addChild($menuTemp->getName(), ['uri'=>'#']);
            }else{
                if($menu->getAttributes() != "") {
                    $subMenu = $menu->addChild($menuTemp->getName(), [
                        'route' => $menuTemp->getPath(),
                        'routeParameters' => json_decode($menuTemp->getAttributes(), true)
                    ]);
                }else{
                    $subMenu = $menu->addChild($menuTemp->getName(), ['route' => $menuTemp->getPath()]);
                }
            }

            $subMenusTemp = $menuRepository->findBy(['parent'=>$menuTemp, 'active'=>true], ['order'=>'asc']);
            if(!empty($subMenusTemp)) {
                $subMenu->setChildrenAttribute('class', 'drop-down one-column hover-expand');
                foreach ($subMenusTemp as $subMenuTemp) {
                    $subMenu->addChild($subMenuTemp->getName()  , [
                        'route' => $subMenuTemp->getPath(),
                        'routeParameters' => json_decode($subMenuTemp->getAttributes(), true)
                    ]);
                }
            }
        }

        return $menu;
    }

    public function adminMenu(Array $options)
    {
        $menu = $this->factory->createItem('root')->setChildrenAttribute('class', 'nav nav-list');

        $menu->addChild('Dashboard', ['route'=>'cilantro_admin_index_dashboard'])->setAttribute('icon', 'tachometer');
        $menu->addChild('Menu', ['route'=>'cilantro_admin_menu_index'])->setAttribute('icon', 'bars');
        $menu->addChild('Facebook', ['route'=>'cilantro_admin_video_facebooklist'])->setAttribute('icon', 'facebook');
        $menu->addChild('Youtube', ['route'=>'cilantro_admin_youtube_channels'])->setAttribute('icon', 'youtube');
        $menu->addChild('Contacto', ['route'=>'cilantro_admin_contacto_index'])->setAttribute('icon', 'envelope');
        $menu->addChild('Usuarios', ['route'=>'cilantro_admin_user_index'])->setAttribute('icon', 'user');
        $menu->addChild('Connect', ['route'=>'cilantro_admin_connect_servicelist'])->setAttribute('icon', 'plug');

        return $menu;
    }
}