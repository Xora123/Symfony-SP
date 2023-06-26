<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailController extends AbstractController
{
    #[Route('/detail/{id}', name: 'app_post_show', methods: ['GET', 'POST'])]
    public function index(Post $post, Request $request, CommentRepository $commentRepository): Response 
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setUser($this->getUser())
                ->setPost($post);
            ;
            $commentRepository->add($comment);
            return $this->redirectToRoute('app_post_show', ["id" => $post->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('detail/index.html.twig', [
            "post" => $post,
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }
}
 





