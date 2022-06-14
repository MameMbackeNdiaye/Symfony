<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRoleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRolesController extends AbstractController
{
    #[Route('/user/roles/add', name: 'app_user_roles')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(UserRoleType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $user->addUserRole();
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            // ... perform some action, such as saving the task to the database


        }
        return $this->redirectToRoute('app_user_roles');

    }
}
