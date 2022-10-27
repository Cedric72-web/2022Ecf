<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\NewModuleType;
use App\Form\EditModuleType;
use App\Repository\ModuleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/module', name: 'module_')]
class ModuleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ModuleRepository $modules): Response
    {
        return $this->render("admin/module/index.html.twig", [
            'modules' => $modules->findAll()
        ]);
    }

    #[Route('module/new', name: 'nouveau_module')]
    public function newModule(Request $request, ManagerRegistry $doctrine): Response
    {
        $module = new Module();

        $form = $this->createForm(NewModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute("module_index");
        }
        return $this->render('admin/newmodule.html.twig', [
            "form" => $form->createview(),
        ]); 
    }

    #[Route('/module/edit/{id}', name: 'modifier_module')]
    public function editUser(Module $module, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(EditModuleType::class, $module);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($module);
            $entityManager->flush();

            $this->addFlash('message', 'Module modifié avec succès');
            return $this->redirectToRoute('module_index');
        }

        return $this->render('admin/editmodule.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    #[Route('/module/delete/{id}', name: 'supprimer_module')]
    public function deleteUser(Module $module, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($module);
        $entityManager->flush();
        return $this->redirectToRoute(('module_index'));
    }
}
