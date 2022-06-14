<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{

    #[Route('/categories/liste', name: 'app_categories')]
    public function index(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $c = new Categorie();
        $form = $this->createForm(CategorieType::class, $c,
                                    array('action' => $this->generateUrl('app_categories_add'))
                                );

        $data['form'] = $form->createView();
        $data['categories'] = $em->getRepository(Categorie::class)->findAll();
        return $this->render('categories/index.html.twig', $data);
    }

    #[Route('/categories/get/{id}', name: 'app_categories_get')]

    public function getCategorie($id)
    {
        return $this->render('categories/index.html.twig');
    }

    #[Route('/categories/add', name: 'app_categories_add')]

    public function add(ManagerRegistry $doctrine,Request $request)
    {
        $c = new Categorie();
        $form = $this->createForm(CategorieType::class, $c);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $c = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($c);
            $em->flush();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_categories');
        }

    }



}
