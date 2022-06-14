<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Form\RoleType;
use App\Repository\RolesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RolesController extends AbstractController
{
    #[Route('/roles/liste', name: 'app_roles')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $r = new Roles();
        $form = $this->createForm(RoleType::class, $r,
                                    array('action' => $this->generateUrl('app_roles_add'))
                                );
        $data['form'] = $form->createView();
        $data['roles'] = $em->getRepository(Roles::class)->findAll();
        return $this->render('roles/index.html.twig', $data);
    }
  

    #[Route('/roles/add', name: 'app_roles_add')]

    public function add(ManagerRegistry $doctrine,Request $request)
    {
        $r = new Roles();
        $forme = $this->createForm(RoleType::class, $r);
        $forme->handleRequest($request);
        if ($forme->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $r = $forme->getData();
            $em = $doctrine->getManager();
            $em->persist($r);
            $em->flush();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_roles');
        }
    }

}
