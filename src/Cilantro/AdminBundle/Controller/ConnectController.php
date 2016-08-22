<?php

namespace Cilantro\AdminBundle\Controller;

use Cilantro\AdminBundle\Entity\SocialNetworkService;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Google_Client;
use Google_Service_YouTube;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\Tests\Service;
use Symfony\Component\HttpFoundation\Request;

class ConnectController extends Controller
{
    /**
     * @Route("/services")
     */
    public function serviceListAction()
    {
        if (!session_id()) {
            session_start();
        }

        $breadcrumbs = [['title'=>'Inicio']];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        $fb = new Facebook([
            'app_id' => $this->container->getParameter('facebook_app_id'),
            'app_secret' => $this->container->getParameter('facebook_app_secret'),
            'default_graph_version' => 'v2.7'
        ]);
        $permissions = ['manage_pages'];
        $helper = $fb->getRedirectLoginHelper();
        $callbackUrl = $this->container->get('router')->getContext()->getScheme().'://'.
            $this->container->get('router')->getContext()->getHost().':8080'.
            $this->generateUrl('cilantro_admin_connect_facebookcallback');
        $facebookLink = $helper->getLoginUrl($callbackUrl, $permissions);

        $client = new Google_Client();
        $client->setAuthConfigFile($this->container->get('kernel')->getRootDir().'/cilantromedia.json');
        $client->addScope(Google_Service_YouTube::YOUTUBE_READONLY);
        $callbackUrl = $this->container->get('router')->getContext()->getScheme().'://'.
            $this->container->get('router')->getContext()->getHost().':8080'.
            $this->generateUrl('cilantro_admin_connect_googlecallback');
        $client->setRedirectUri($callbackUrl);
        $client->setAccessType("offline");
        $auth_url = $client->createAuthUrl();

        return $this->render('@CilantroAdmin/Service/list.html.twig', ['contentTitle'=>'Conexión a redes sociales',
            'facebookLink' => $facebookLink,
            'youtubeLink' => $auth_url,
            'breadcrumbs' => $breadcrumbsHtml]);
    }

    /**
     * @Route("/services/facebook/callback")
     */
    public function facebookCallbackAction()
    {
        if (!session_id()) {
            session_start();
        }

        $fb = new Facebook([
            'app_id' => $this->container->getParameter('facebook_app_id'),
            'app_secret' => $this->container->getParameter('facebook_app_secret'),
            'default_graph_version' => 'v2.7'
        ]);

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (isset($accessToken)) {
            $facebookAccessToken = (string) $accessToken;

            $oAuth2Client = $fb->getOAuth2Client();
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($facebookAccessToken);

            $fb->setDefaultAccessToken($longLivedAccessToken);

            try {
                $response = $fb->get('/me');
                $userNode = $response->getGraphUser();
                $socialNetworkService = new SocialNetworkService();
                $socialNetworkService->setAccessToken($longLivedAccessToken);
                $socialNetworkService->setName('Facebook');
                $socialNetworkService->setUserId($userNode->getId());
                $em = $this->getDoctrine()->getManager();
                $em->persist($socialNetworkService);
                $em->flush();
            } catch(FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        }

        return $this->redirectToRoute('cilantro_admin_connect_servicelist');
    }

    /**
     * @Route("/services/google/callback")
     */
    public function googleCallbackAction(Request $request)
    {
        if (!session_id()) {
            session_start();
        }

        $em = $this->getDoctrine()->getManager();

        $client = new Google_Client();
        $client->setAuthConfigFile($this->container->get('kernel')->getRootDir().'/cilantromedia.json');
        $client->addScope(Google_Service_YouTube::YOUTUBE_READONLY);
        $callbackUrl = $this->container->get('router')->getContext()->getScheme().'://'.
            $this->container->get('router')->getContext()->getHost().':8080'.
            $this->generateUrl('cilantro_admin_connect_googlecallback');
        $client->setRedirectUri($callbackUrl);
        $client->setAccessType("offline");

        $client->authenticate($request->query->get('code'));
        $access_token = $client->getAccessToken();

        $snRepository = $em->getRepository('CilantroAdminBundle:SocialNetworkService');
        $socialNetworkService = $snRepository->findOneBy(['name'=>'Google']);
        if(empty($socialNetworkService)) {
            $socialNetworkService = new SocialNetworkService();
            $socialNetworkService->setAccessToken(json_encode($access_token));
            $socialNetworkService->setName('Google');
            $socialNetworkService->setUserId($client->getClientId());
        }else{
            $socialNetworkService->setAccessToken(json_encode($access_token));
        }

        $em->persist($socialNetworkService);
        $em->flush();

        return $this->redirectToRoute('cilantro_admin_connect_servicelist');
    }
}