<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\UtilsService;
use App\Repository\UserRepository;


class UserController extends AbstractController
{
    #[Route('/user/add', name: 'app_user_add')]
    public function addUtilisateur(Request $request, EntityManagerInterface $em, UserRepository $repo): Response
    {
        $msg = "";
        $gens = new User();
        $form = $this->createForm(UserType::class, $gens);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){

            // clean les values
            $gens->setName(utilsService::cleanInput($gens->getName()));
            $gens->setFirstName(utilsService::cleanInput($gens->getFirstName()));
            $gens->setMail(utilsService::cleanInput($gens->getMail()));
            $gens->setPssword(utilsService::cleanInput($gens->getPssword()));
            if($gens->getImg()){
                $gens->setImg(utilsService::cleanInput($gens->getImg()));
            }

            if(!$repo->findOneBy(['mail'=>$gens->getMail()])){
                //miam miam le mot de passe
                $gens->setPssword(md5($gens->getPssword()));
                
                $em->persist($gens);
                $em->flush();
                $msg = "L'utilisateur a bien été ajouté dans la BDD :)";    
            }else{
                $msg = "Ce compte existe déjà";
            }
        }
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            'msg' => $msg
        ]);
    }
}
