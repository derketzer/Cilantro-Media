<?php

namespace Cilantro\AdminBundle\Controller;

use Cilantro\AdminBundle\Entity\User;
use Cilantro\AdminBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class UserController extends Controller
{
    /**
     * @Route("/users");
     */
    public function indexAction()
    {
        $userRepository = $this->getDoctrine()->getManager()->getRepository('CilantroAdminBundle:User');
        $users = $userRepository->findAll();

        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
            ['title'=>'Usuarios']
        ];

        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        return $this->render('@CilantroAdmin/Users/list.html.twig', [
            'users'=>$users,
            'contentTitle'=>'Usuarios',
            'breadcrumbs' => $breadcrumbsHtml,
        ]);
    }

    /**
     * @Route("/user");
     */
    public function addAction(Request $request)
    {
        $breadcrumbs = [['title'=>'Inicio', 'path'=>'cilantro_admin_index_dashboard'],
            ['title'=>'Usuarios', 'path'=>'cilantro_admin_user_index'],
            ['title'=>'Agregar usuario']
        ];
        $breadcrumbsHtml = $this->get('cilantro.utils')->generateBreadcrumbs($breadcrumbs);

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()) {
            try {
                $user->setEnabled(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('cilantro_admin_user_index');
            }catch(\Exception $e){
                $error = new FormError('Hubo un error al guardar el formulario');
                $form->addError($error);
            }
        }

        return $this->render('@CilantroAdmin/Users/user.html.twig', [
            'contentTitle'=>'Agregar',
            'breadcrumbs' => $breadcrumbsHtml,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/{userId}/lock");
     */
    public function lockAction($userId)
    {
        if(empty($userId))
            return $this->redirectToRoute('cilantro_admin_user_index');

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(['id'=>$userId]);

        if(!empty($user)){
            $user->setLocked(true);
            $userManager->updateUser($user);
        }

        return $this->redirectToRoute('cilantro_admin_user_index');
    }

    /**
     * @Route("/user/{userId}/unlock");
     */
    public function unlockAction($userId)
    {
        if(empty($userId))
            return $this->redirectToRoute('cilantro_admin_user_index');

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(['id'=>$userId]);

        if(!empty($user)){
            $user->setLocked(false);
            $userManager->updateUser($user);
        }

        return $this->redirectToRoute('cilantro_admin_user_index');
    }

    /**
     * @Route("/user/{userId}/delete");
     */
    public function deleteAction($userId)
    {
        if(empty($userId))
            return $this->redirectToRoute('cilantro_admin_user_index');

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(['id'=>$userId]);

        if(!empty($user)){
            $userManager->deleteUser($user);
        }

        return $this->redirectToRoute('cilantro_admin_user_index');
    }
}
