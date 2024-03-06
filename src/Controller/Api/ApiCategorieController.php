<?php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ApiCategorieController extends AbstractController{
    private CategoryRepository $categoryRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $manager;
    
    public function __construct(CategoryRepository $categoryRepository, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $this->categoryRepository = $categoryRepository;

        $this->serializer = $serializer;

        $this->manager = $manager;
    }

    #[Route('/api/categorie/all', name: 'app_api_category_all', methods: 'GET')]
    public function getAllCategories():Response{
        return $this->json($this->categoryRepository->findAll(),200,[
            "Access-Control-Allow-Origin" => "*",],
            ["groups" => "api"]
        );
    }

    #[Route('/api/categorie/add', name: 'app_api_category_add', methods: 'POST')]
    public function addCategory(Request $request):Response{
        //$data = $this->serializer->decode($request->getContent(), "json");
        //$categorie = $this->serializer->deserialize($request->getContent(),Category::class,"json");
        
        $data = $request->getContent();

        $category = $this->serializer->deserialize($data,Category::class, "json");

        $this->manager->persist($category);

        $this->manager->flush();
        
        return $this->json($category,200,[
            "Access-Control-Allow-Origin" => "*",
        ]);
    }
}