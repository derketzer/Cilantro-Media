<?php

namespace Cilantro\MediaBundle\Menu;

use Knp\Menu\FactoryInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

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
        $menusTemp = $menuRepository->findBy(['parent'=>NULL]);

        foreach($menusTemp as $menuTemp){
            if($menuTemp->getPath() == NULL){
                $subMenu = $menu->addChild($menuTemp->getName(), ['uri'=>'#']);
            }else{
                $subMenu = $menu->addChild($menuTemp->getName(), ['route' => $menuTemp->getPath()]);
            }

            $subMenusTemp = $menuRepository->findBy(['parent'=>$menuTemp]);
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
        $menusTemp = $menuRepository->findBy(['parent'=>NULL]);

        foreach($menusTemp as $menuTemp){
            if($menuTemp->getPath() == NULL){
                $subMenu = $menu->addChild($menuTemp->getName(), ['uri'=>'#']);
            }else{
                $subMenu = $menu->addChild($menuTemp->getName(), ['route' => $menuTemp->getPath()]);
            }

            $subMenusTemp = $menuRepository->findBy(['parent'=>$menuTemp]);
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
}