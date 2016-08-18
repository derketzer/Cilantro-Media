<?php

namespace Cilantro\AdminBundle\Service;

use Cilantro\AdminBundle\Entity\FacebookPage;
use Cilantro\AdminBundle\Entity\FacebookVideoList;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Facebook\Facebook;
use Symfony\Component\DependencyInjection\Container;

class FacebookService
{
    private $em;
    private $container;
    private $fb;
    private $log;

    public function __construct(Doctrine $doctrine, Container $container)
    {
        $this->em = $doctrine->getManager();
        $this->container = $container;

        $this->fb = new Facebook([
            'app_id' => $this->container->getParameter('facebook_app_id'),
            'app_secret' => $this->container->getParameter('facebook_app_secret'),
            'default_graph_version' => 'v2.7'
        ]);
    }

    public function getPages()
    {
        $snServiceRepository = $this->em->getRepository('CilantroAdminBundle:SocialNetworkService');
        $connectedAccounts = $snServiceRepository->findBy(['name'=>'Facebook']);

        if(!empty($connectedAccounts)) {
            foreach ($connectedAccounts as $account) {
                $this->fb->setDefaultAccessToken($account->getAccessToken());

                $response = $this->fb->get('/me/accounts?fields=link,name,id,access_token');
                $responseBody = $response->getDecodedBody();
                $facebookPages = $responseBody['data'];

                $facebookPageRepository = $this->em->getRepository('CilantroAdminBundle:FacebookPage');

                if(!empty($facebookPages)) {
                    foreach ($facebookPages as $page) {
                        $facebookPageTemp = $facebookPageRepository->findBy(Array('facebookId' => $page['id']));

                        if (empty($facebookPageTemp)) {
                            $facebookPage = new FacebookPage();
                            $facebookPage->setName($page['name']);
                            $facebookPage->setFacebookId($page['id']);
                            $facebookPage->setUrl($page['link']);
                            $facebookPage->setAccessToken($page['access_token']);
                            $facebookPage->setActive(false);

                            try {
                                $this->em->persist($facebookPage);
                                $this->em->flush();

                                echo 'Se agregó: ' . $page['name'] . "\n";
                            } catch (\Exception $e) {
                                echo $e->getMessage();
                                echo '<br />DB Error!';
                                exit();
                            }
                        }
                    }
                }
            }
        }

        return true;
    }

    public function getVideoList()
    {
        $facebookPageRepository = $this->em->getRepository('CilantroAdminBundle:FacebookPage');
        $pages = $facebookPageRepository->findBy(['active' => true]);

        $facebookVideoListRepository = $this->em->getRepository('CilantroAdminBundle:FacebookVideoList');

        if (!empty($pages)) {
            foreach ($pages as $page) {
                $this->fb->setDefaultAccessToken($page->getAccessToken());

                $response = $this->fb->get('/' . $page->getFacebookId() . '/video_lists');
                $responseBody = $response->getDecodedBody();
                $facebookVideoLists = $responseBody['data'];

                foreach ($facebookVideoLists as $facebookVideoList) {
                    $facebookVideoListTemp = $facebookVideoListRepository->findOneBy(['facebookId'=>$facebookVideoList['id']]);
                    if(empty($facebookVideoListTemp)){
                        $facebookVideoListNew = new FacebookVideoList();
                        $facebookVideoListNew->setFacebookId($facebookVideoList['id']);
                        $facebookVideoListNew->setFacebookPage($page);
                        $facebookVideoListNew->setTitle($facebookVideoList['title']);
                        $facebookVideoListNew->setActive(false);

                        try {
                            $this->em->persist($facebookVideoListNew);
                            $this->em->flush();

                            echo 'Se agregó: ' . $facebookVideoList['title'] . "\n";
                        } catch (\Exception $e) {
                            echo $e->getMessage();
                            echo '<br />DB Error!';
                            exit();
                        }
                    }
                }
            }
        }
    }
    // facebookVideoList/videos?fields=id,title,description,content_tags,picture,published
}