<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{

    #[Route('/produits/liste', name: 'app_produits')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator)
    {
        $em = $doctrine->getManager();
        $p = new Produit();
        $form = $this->createForm(ProduitType::class, $p,
                                    array('action' => $this->generateUrl('app_produits_add'))
                                );
        $data['form'] = $form->createView();
        $data['produits'] = $em->getRepository(Produit::class)->findAll();
        $data['produits'] = $paginator->paginate(
            $data['produits'], 
            $request->query->getInt('page', 1),  
            5
        );                

        // $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        return $this->render('produits/index.html.twig', $data);

    }

    #[Route('/produits/get/{id}', name: 'app_produits_get')]

    public function getProduit($id)
    {
        return $this->render('produits/index.html.twig');
    }

    #[Route('/produits/add', name: 'app_produits_add')]

    public function add(ManagerRegistry $doctrine,Request $request)
    {
        $p = new Produit();
        $form = $this->createForm(ProduitType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $p = $form->getData();
            $p->setUser($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($p);
            $em->flush();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_produits');
        }

    }



}
