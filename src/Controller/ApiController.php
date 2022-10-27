<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Repository\FranchiseRepository;
use App\Repository\PartnerRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route('/franchise', name: 'franchise_list', methods:"GET")]
    public function index(FranchiseRepository $franchiseRepo)
    {
        return $this->json($franchiseRepo->findAll(), 200, [], ['groups' => 'franchise:read']);
    }

    #[Route('/franchise/view/{id}', name: 'voir_franchise')]
    public function viewFranchise(Franchise $franchise, FranchiseRepository $franchiseRepo, PartnerRepository $repository, Request $request)
    {
        return $this->json($franchiseRepo->findById($franchise), 200, [], ['groups' => ('franchise:read')]);
        // $status = $request->request->get('choicePartner');
        // if ($status) {
        //     $partners = $repository->findByStatus($status);
        // }
        // $partners = $repository->findById($franchise);
        // return $this->render('admin/viewfranchise.html.twig', [
        //     'franchise' => $franchise,
        //     'partners' => $partners
        // ]);
    }
}