<?php

namespace Cilantro\AdminBundle\Service;

use Cilantro\MediaBundle\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\DependencyInjection\Container;

class MenuService
{
    private $em;
    private $container;

    public function __construct(Doctrine $doctrine, Container $container)
    {
        $this->em = $doctrine->getManager();
        $this->container = $container;
    }

    public function generate()
    {
        $menuRepository = $this->em->getRepository('CilantroMediaBundle:Menu');
        $menus = $menuRepository->findBy(['generated'=>true]);
        if(!empty($menus)) {
            try {
                foreach ($menus as $menu){
                    $this->em->remove($menu);
                }
                $this->em->flush();
            }catch(\Exception $e){
                echo $e->getMessage();
            }
        }

        $youtubeChannelRepository = $this->em->getRepository('CilantroAdminBundle:YoutubeChannel');
        $youtubeChannels = $youtubeChannelRepository->findAll();

        if(!empty($youtubeChannels)) {
            $menuTV = $menuRepository->findOneBy(['name' => 'Televisión']);
            $menuAdultos = $menuRepository->findOneBy(['name' => 'TV para adultos']);

            try {
                $menuOrder = 1;
                foreach ($youtubeChannels as $youtubeChannel) {
                    $menu = new Menu();
                    $menu->setActive(false);
                    $menu->setAttributes(json_encode(['slug' => $youtubeChannel->getSlug()]));
                    $menu->setGenerated(true);
                    if ($youtubeChannel->getAdult()) {
                        $menu->setParent($menuAdultos);
                    } else {
                        $menu->setParent($menuTV);
                    }
                    $menu->setName($youtubeChannel->getTitle());
                    $menu->setOrder($menuOrder);
                    $menu->setPath('cilantro_media_youtube_episodes');
                    $menu->setSource(1);

                    $this->em->persist($menu);
                    $menuOrder++;
                }

                $this->em->flush();
            }catch(\Exception $e){
                echo $e->getMessage();
            }
        }

        $facebookVideoListRepository = $this->em->getRepository('CilantroAdminBundle:FacebookVideoList');
        $facebookVideoLists = $facebookVideoListRepository->findAll();

        if(!empty($facebookVideoLists)) {
            $menuRadio = $menuRepository->findOneBy(['name' => 'Radio']);

            try {
                $menuOrder = 1;
                foreach ($facebookVideoLists as $facebookVideoList) {
                    $menu = new Menu();
                    $menu->setActive(false);
                    $menu->setAttributes(json_encode(['slug' => $facebookVideoList->getSlug()]));
                    $menu->setGenerated(true);
                    $menu->setParent($menuRadio);
                    $menu->setName($facebookVideoList->getTitle());
                    $menu->setOrder($menuOrder);
                    $menu->setPath('cilantro_media_facebook_episodes');
                    $menu->setSource(2);

                    $this->em->persist($menu);
                    $menuOrder++;
                }

                $this->em->flush();
            }catch(\Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}