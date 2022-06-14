<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EntreesController extends AbstractController
{
    #[Route('/entrees', name: 'app_entrees')]
    public function index(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $e = new Entree();
        $form = $this->createForm(EntreeType::class, $e,
                                    array('action' => $this->generateUrl('app_entrees_add'))
                                );

        $data['form'] = $form->createView();
        $data['entrees'] = $em->getRepository(Entree::class)->findAll();
        return $this->render('entrees/index.html.twig', $data);
    }

    #[Route('/entrees/add', name: 'app_entrees_add')]

    public function add(ManagerRegistry $doctrine,Request $request)
    {
        $e = new Entree();
        $form = $this->createForm(EntreeType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $e = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($e);
            $em->flush();
            //Mis a jour du produit
            $p = $em->getRepository(Produit::class)->find($e->getProduit()->getId());
            $stock = $p->getStock() + $e->getQuantite();
            $p -> setStock($stock);
            $em -> flush();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_entrees');
        }

    }


}
