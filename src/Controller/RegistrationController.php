<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthentificationAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/Personnel/liste', name: 'app_register')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator)
    {
        $em = $doctrine->getManager();
        $u = new User();
        $form = $this->createForm(RegistrationFormType::class, $u,
                                    array('action' => $this->generateUrl('app_register_add'))
                                );

        $data['form'] = $form->createView();
        $data['user'] = $em->getRepository(User::class)->findAll();
        $data['user'] = $paginator->paginate(
            $data['user'], 
            $request->query->getInt('page', 1),  
            5
        );                

        return $this->render('registration/register.html.twig', $data);
    }


    #[Route('/Personnel/add', name: 'app_register_add')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthentificationAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

        }

        return $this->redirectToRoute('app_register');
    }
    #[Route('/Personnel/modifier{id}', name: 'app_register_modifier')]
    public function editUser( User $user, Request $request, ManagerRegistry $doctrine){
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_register');
            $this->addFlash('message', 'Utilisateur modifié avec succès !');

        }

        return $this->render('registration/editUser.html.twig',[
            'userForm' => $form->createView()
        ]);
   }





}
