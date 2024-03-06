<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository) 
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('/home', name: 'app_home')]
    public function articleAll():Response
    {
        $articles = $this->articleRepository->findAll();

        return $this->render('article/home.html.twig', [
                'articles' => $articles,
        ]);
    }

    #[Route('/home/article/{id}', name: 'app_article')]
    public function articleById($id):Response
    {
        //dd($this->articleRepository->find($id));
        return $this->render('article/article_detail.html.twig', [
            'article' => $this->articleRepository->find($id),

        ]);
    }
}
