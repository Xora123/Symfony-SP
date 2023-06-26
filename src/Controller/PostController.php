<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function showPosts(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy(['status' => 'published'],['createdAt' => 'desc']);
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setEmail('aze@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('kekeke');
        $user->setFirstname('jean');
        $user->setLastname('jeans');
        $user->setUsername('keke');
        $user->setIsVerified(1);

        $post = new Post();
        $post->setTitle('ProductKeyboard');
        $post->setContent('Ergonomic and stylish!');
        $post->setStatus('salut');
        $post->setCreatedAt(new \DateTimeImmutable('2010-02-03 04:05:06 America/New_York'));
        $post->setUser($user);

        $entityManager->persist($user);
        $entityManager->persist($post);
        $entityManager->flush();

        return new Response('Saved new product with id ' . $post->getId());
    }
}
