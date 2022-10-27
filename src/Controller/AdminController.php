<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewUserType;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/admin', name: 'admin_')]

class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/users', name: 'utilisateurs')]
    public function usersList(UserRepository $users)
    {
        return $this->render("admin/user/users.html.twig", [
            'users' => $users->findAll()
        ]);
    }

    #[Route('/user/new', name: 'nouvel_utilisateur')]
    public function newUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine):Response
    {
        $user = new User($userPasswordHasher);

        $form = $this->createForm(NewUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setCreatedAt(new \DateTime());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute("admin_utilisateurs");
        }
        return $this->render('admin/user/newuser.html.twig', [
            "form" => $form->createview(),
        ]);
    }

    #[Route('/user/edit/{id}', name: 'modifier_utilisateur')]
    public function editUser(User $user, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/user/edituser.html.twig', [
            'userForm' =>$form->createView()
        ]);
    }

    #[Route('/user/delete/{id}', name: 'supprimer_utilisateur')]
    public function deleteUser(User $user, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute(('admin_utilisateurs'));
    }
}
