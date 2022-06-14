<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SoriteRepository;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortiesController extends AbstractController
{
    #[Route('/sorties', name: 'app_sorties')]
    public function index(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $s = new Sortie();
        $form = $this->createForm(SortieType::class, $s,
                                    array('action' => $this->generateUrl('app_sorties_add'))
                                );

        $data['form'] = $form->createView();
        $data['sorties'] = $em->getRepository(Sortie::class)->findAll();
        return $this->render('sorties/index.html.twig', $data);
    }

    #[Route('/sorties/add', name: 'app_sorties_add')]

    public function add(ManagerRegistry $doctrine,Request $request)
    {
        $s = new Sortie(); 
        $form = $this->createForm(SortieType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $s = $form->getData();
            $em = $doctrine->getManager();
            $qsortie = $s->getQuantite();
            $psortie = $s->getProduit();
            $p = $em->getRepository(Produit::class)->find($s->getProduit()->getId());
            if ($p->getStock() < $s->getQuantite()) {
                $em = $doctrine->getManager();
                $s = new Sortie();
                $form = $this->createForm(SortieType::class, $s,
                                            array('action' => $this->generateUrl('app_sorties_add'))
                                        );        
                $data['form'] = $form->createView();
                $data['sorties'] = $em->getRepository(Sortie::class)->findAll();        
                $data['errormessage'] ='Le stock de '.$psortie.' disponible inferieur à '.$qsortie;
                return $this->render('sorties/index.html.twig', $data);

            }else{
                $em->persist($s);
                $em->flush();
                //Mise a jour du produit
                $stock = $p->getStock() - $s->getQuantite();
                $p -> setStock($stock);
                $em->flush();
                return $this->redirectToRoute('app_sorties');
            }
            // ... perform some action, such as saving the task to the database


        }

    }
}
