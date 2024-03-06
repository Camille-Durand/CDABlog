<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CategoryType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class CategoryController extends AbstractController
{
    #[Route('/category/add', name: 'app_category_add')]
    public function addCategorie(Request $request, EntityManagerInterface $em): Response
    {
        $msg = "";
        $categorie = new Category();
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($categorie);
            $em->flush();
            $msg = "La catégorie a bien été ajouté dans la BDD :)";
        }
        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
            'msg' => $msg
        ]);
    }
}
