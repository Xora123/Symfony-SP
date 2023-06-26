<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Controller\SearchController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(PostRepository $repository,Request $rq): Response
    {
        $search=$rq->query->get('search');
        $post=$repository->search($search);
        
        return $this->render('search/index.html.twig', [
            "posts" => $post
        ]);
    }
}
