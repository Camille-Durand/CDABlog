<?php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class ApiArticleController extends AbstractController{
    private ArticleRepository $articleRepository;
    
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('/api/articles/all', name: 'app_api_articles_all', methods: 'GET')]
    public function getAllArticles():Response{
        return $this->json($this->articleRepository->findAll(),200,[
            "Access-Control-Allow-Origin" => "*",],
            ["groups" => "api"]
        );
    }
}