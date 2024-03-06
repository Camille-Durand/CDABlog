<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ArticleType;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\UtilsService;

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

    #[Route('/article/add', name: 'app_article_add')]
    public function addArticle(Request $request, EntityManagerInterface $em, ArticleRepository $repo): Response
    {
        $msg = "";
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){

            // clean les values
            $article->setTitle(utilsService::cleanInput($article->getTitle()));
            $article->setContent(utilsService::cleanInput($article->getContent()));
            if($article->getImgArticle()){
                $article->setImgArticle(utilsService::cleanInput($article->getImgArticle()));
            }

            $em->persist($article);
            $em->flush();
            $msg = "L'article a bien été ajouté dans la BDD :)";    
        }
        return $this->render('article/article_add.html.twig', [
            'form' => $form->createView(),
            'msg' => $msg
        ]);
    }
}
