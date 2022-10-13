<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\User;
use App\Form\NewFranchiseType;
use App\Form\EditFranchiseType;
use App\Repository\FranchiseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/franchise', name: 'franchise_')]

class FranchiseController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(FranchiseRepository $franchises): Response
    {
        return $this->render("franchise/index.html.twig", [
            'franchises' => $franchises->findAll()
        ]);
    }

    #[Route('/franchise/new', name: 'nouvelle_franchise')]
    public function newFranchise(Request $request, ManagerRegistry $doctrine):Response
    {
        $franchise = new Franchise();

        $form = $this->createForm(NewFranchiseType::class, $franchise);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($franchise);
            $entityManager->flush();

            return $this->redirectToRoute("franchise_index");
        }
        return $this->render('admin/newfranchise.html.twig', [
            "form" => $form->createview(),
        ]);        
    }

    #[Route('/franchise/edit/{id}', name: 'modifier_franchise')]
    public function editUser(Franchise $franchise, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(EditFranchiseType::class, $franchise);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($franchise);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('franchise_index');
        }

        return $this->render('admin/editfranchise.html.twig', [
            'franchiseForm' =>$form->createView()
        ]);
    }

    #[Route('/franchise/delete/{id}', name: 'supprimer_franchise')]
    public function deleteUser(Franchise $franchise, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($franchise);
        $entityManager->flush();
        return $this->redirectToRoute(('franchise_index'));
    }
}
