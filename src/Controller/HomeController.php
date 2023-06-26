<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $post_repo, Request $request, EntityManagerInterface $em): Response
    {
        # Souscription de l'utilisateur
        /** @var User $user */
        $posts =$post_repo->findBy(['status' => 'published'],['createdAt' => 'desc']);
        return $this->render('home/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
