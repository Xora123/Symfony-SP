<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $this->denyAccessUnlessGranted('COMMENT_EDIT', $comment);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->add($comment);
            return $this->redirectToRoute('app_post_show', ["id" => $comment->getPost()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $this->denyAccessUnlessGranted('COMMENT_EDIT', $comment);
        
        $post_id = $comment->getPost()->getId();
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment);
        }

        return $this->redirectToRoute('app_post_show', ["id" => $post_id], Response::HTTP_SEE_OTHER);
    }

    /**
     * Fonction pour les likes
     *
     * @param Comment $comment
     * @param ObjectManager $manager
     * @param CommentRepository $comment_repo
     * @return Reponse
     */

    #[Route('/{id}/like', name: 'app_comment_like', methods: ['POST', 'GET'])]
    public function like(Comment $comment, EntityManagerInterface $manager, CommentRepository $commentRepository) : Response 
    {
        $user = $this->getUser();

        if(!$user) return $this->json([
            'code' => 403,
            'message' => 'Unauthorized',
        ], 403);

        if($comment->getLikes()->contains($user)){

            $comment->removeLike($user);
            $manager->flush();

            return $this->json([
                'message' => 'Like supprimé',
                'likes' => count($comment->getLikes())
            ], 200);
        }

        $comment->addLike($user);
        $manager->flush();

        return $this->json([
            'message' => 'ça marche bien',
            'likes' => count($comment->getLikes())
        ], 200);
    }
}