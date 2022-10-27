<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\NewFranchiseType;
use App\Form\EditFranchiseType;
use App\Repository\FranchiseRepository;
use App\Repository\PartnerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/franchise', name: 'franchise_')]

class FranchiseController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(FranchiseRepository $franchisesRepo, PartnerRepository $partnerRepo): Response
    {
        $partners = $partnerRepo->findAll();

        // Récupération de toutes les salles
        return $this->render("admin/franchise/index.html.twig", [
            'franchises' => $franchisesRepo->findAll(),
            'partners' => $partners
        ]);
    }

    #[Route('/franchise/new', name: 'nouvelle_franchise')]
    public function newFranchise(Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine):Response
    {
        $franchise = new Franchise($userPasswordHasher);

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
    public function editFranchise(Franchise $franchise, Request $request, ManagerRegistry $doctrine)
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
    public function deleteFranchise(Franchise $franchise, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($franchise);
        $entityManager->flush();
        return $this->redirectToRoute(('franchise_index'));
    }

    #[Route('/franchise/view/{id}', name: 'voir_franchise')]
    public function viewFranchise(Franchise $franchise, PartnerRepository $repository, Request $request)
    {
        $status = $request->request->get('choicePartner');
        dump($status);
        if ($status) {
            $partners = $repository->findByStatus($status);
        }
        $partners = $repository->findById($franchise);
        return $this->render('admin/viewfranchise.html.twig', [
            'franchise' => $franchise,
            'partners' => $partners
        ]);
    }
}
