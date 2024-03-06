<?php
namespace App\Controller;
//import des modules
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\GestionUserType;
use App\Entity\GestionUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class RegisterController extends AbstractController
{
    //fonction pour ajouter un compte utilisateur
    #[Route('/register', name: 'app_register')]
    public function addUser(Request $request,
    EntityManagerInterface $manager,UserPasswordHasherInterface $hash): Response
    {
        //instance d’un objet User
        $user = new GestionUser();
        //variable qui contient un objet UserType (formulaire)
        $form = $this->createForm(GestionUserType::class, $user); 
        //stocker le résultat du formulaire
        $form->handleRequest($request);
        //condition validation du formulaire
        if($form->isSubmitted() && $form->isValid()){
            //récupération du mot de passe en clair
            $pass = $_POST['user']['password'];
            //hasher le mot de passe
            $hassPassword = $hash->hashPassword($user, $pass);
            //setter les valeurs (mot de passe activation et le rôle)
            $user->setPassword($hassPassword);
            $user->setRoles(['ROLE_USER']);
            //faire persister les données
            $manager->persist($user);
            //ajout en BDD
            $manager->flush();
            //génération du formulaire et redirection
            return $this->render('register/index.html.twig', [
                'form' => $form->createView(),
                'add' => $user->getEmail(),
            ]);
        }
        //génération du formulaire
        return $this->render('register/index.html.twig', [
        'form' => $form->createView(),
        'add' => "",
        ]);
    }
} 
