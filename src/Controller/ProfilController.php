<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\EditProfilFormType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{

    #[Route('/profil', name: 'app_profil', methods: ['GET'])]

    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        return $this->render('profil/index.html.twig');
    }

    #[Route('profil/{id}/edit', name: 'app_profil_edit', methods: ['GET', 'POST'])]
    public function editUser(Request $request, User $user, EntityManagerInterface $em, UserRepository $UserRepository) : Response {

        $form = $this->createForm(EditProfilFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $UserRepository->add($user);
            return $this->redirectToRoute('app_profil');
        }

        return $this->renderForm('profil/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('profil/{id}/edit_password', name: 'app_profil_edit_password', methods: ['GET', 'POST'])]
    public function editPassword(Request $request, User $user, EntityManagerInterface $em, UserRepository $UserRepository) : Response {

        $form = $this->createForm(ChangePasswordFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $UserRepository->add($user);
            return $this->redirectToRoute('app_profil');
        }

        return $this->renderForm('profil/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
