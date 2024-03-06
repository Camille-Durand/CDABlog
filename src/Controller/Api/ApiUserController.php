<?php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ApiUserController extends AbstractController{
    private UserRepository $utilisateurRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $manager;
    
    public function __construct(UserRepository $utilisateurRepository, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $this->utilisateurRepository = $utilisateurRepository;

        $this->serializer = $serializer;

        $this->manager = $manager;
    }

    // Fonction permettant de récupérer tous les utilisateurs de la BDD
    #[Route('/api/user/all', name: 'app_api_user_all', methods: 'GET')]
    public function getAllUsers():Response{
        return $this->json($this->utilisateurRepository->findAll(),200,[
            "Access-Control-Allow-Origin" => "*",],
            ["groups" => "api"]
        );
    }

    // Fonction permettant d'ajouter un utilisateur dans la BDD
    #[Route('/api/user/add', name: 'app_api_user_add', methods: 'PUT')]
    public function addUser(Request $request):Response{
        //$data = $this->serializer->decode($request->getContent(), "json");
        //$categorie = $this->serializer->deserialize($request->getContent(),Category::class,"json");
        
        $data = $request->getContent();

        if($data){
            $utilisateur = $this->serializer->deserialize($data,User::class, "json");

            if($this->utilisateurRepository->findOneBy(["mail"=>$utilisateur->getMail()])){
                $message = ["Erreur"=>"Informations d'inscription incorrectes"];
                $code = 400;
            }
    
            $password = $utilisateur->getPssword();
                //hash du password
            $hash = md5($utilisateur->getPssword());
                //setter le hash du mot de passe
            $utilisateur->setPssword($hash);
    
            $this->manager->persist($utilisateur);
    
            $this->manager->flush();
            $message = $utilisateur;
            $code = 200;
        }
        else {
            $message = ["Erreur"=>"Le json est invalide"];
            $code = 400;
        }
       
        return $this->json($message,$code,[
            "Access-Control-Allow-Origin" => "*",
        ]);
    }

    // Fonction permettant de modifier les informations d'un utilisateur dans la BDD
    #[Route('/api/user/update', name: 'app_api_user_update', methods: 'PATCH')]
    public function updateUser(Request $request):Response{

        $data = $request->getContent();

        if($data){
            $utilisateur = $this->serializer->deserialize($data,User::class, "json");

            $recupUser = $this->utilisateurRepository->findOneBy(["mail"=>$utilisateur->getMail()]);

            if($recupUser){
                $recupUser->setName($utilisateur->getName());
                $recupUser->setFirstName($utilisateur->getFirstName());
                $recupUser->setPssword(md5($utilisateur->getPssword()));
                $recupUser->setImg($utilisateur->getImg());

                $this->manager->persist($recupUser);
        
                $this->manager->flush();
                $message = $recupUser;
                $code = 200;
            } else {
                $message = ["Erreur"=>"Informations d'inscription incorrectes"];
                $code = 400;
            }
        }
        else {
            $message = ["Erreur"=>"Le json est invalide"];
            $code = 400;
        }
       
        return $this->json($message,$code,["Access-Control-Allow-Origin" => "*",]);
    }

    // Fonction permettant de supprimer un utilisateur de la BDD
    #[Route('/api/user/{id}', name: 'app_api_user_delete', methods:'DELETE')]
    public function removeUser($id):Response{
        $utilisateur = $this->utilisateurRepository->find($id);
        if($utilisateur){
            $this->manager->remove($utilisateur);
            $this->manager->flush();

            $message = ["Yey"=>"Le compte a bien ete supprime"];
            $code = 200;
        }else{
            $message = ["Erreur"=>"Le compte n'existe pas"];
            $code = 400;
        }
        return $this->json($message,$code,["Access-Control-Allow-Origin" => "*",]);
    }
}