<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\EditPartnerType;
use App\Form\NewPartnerType;
use App\Repository\PartnerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/partner', name: 'salle_')]
class PartnerController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(PartnerRepository $partners): Response
    {
        return $this->render('admin/partner/index.html.twig', [
            'partners' =>$partners->findAll()
        ]);
    }

    #[Route('/partner/new', name: 'nouvelle_salle')]
    public function newPartner(Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine):Response
    {
        $partner = new Partner($userPasswordHasher);

        $form = $this->createForm(NewPartnerType::class, $partner);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute("salle_index");
        }
        return $this->render('admin/newpartner.html.twig', [
            "form" => $form->createview(),
        ]);        
    }

    #[Route('/partner/view/{id}', name: 'voir_salle')]
    public function viewFranchise(Partner $partner,PartnerRepository $repository)
    {
        $partners = $repository->findById($partner);
        return $this->render('admin/viewpartner.html.twig', [
            'partner' => $partner,
            'partners' => $partners
        ]);
    }

    #[Route('/partner/edit/{id}', name: 'modifier_salle')]
    public function editUser(Partner $partner, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(EditPartnerType::class, $partner);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            $this->addFlash('message', 'Salle modifiée avec succès');
            return $this->redirectToRoute('salle_index');
        }

        return $this->render('admin/editpartner.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    #[Route('/partner/delete/{id}', name: 'supprimer_salle')]
    public function deleteUser(Partner $franchise, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($franchise);
        $entityManager->flush();
        return $this->redirectToRoute(('salle_index'));
    }
}
