<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{
    // #[Route('/home',name:'app_home')]
    // public function homeMessage() : Response{
    //     return new Response("Hello World");
    // }

    public function afficherMessage() : Response {
        return new Response("Je suis une potite chaîne de caractères :)");
    }

    #[Route('/afficher/message/bis',name:'app_afficher_message_bis')]
    public function homeMessageBis() : Response{
        return new Response("Je suis encore et toujours une chaîne de caractères :), jsuis juste un ptit peu + grande maintenant!");
    }

    #[Route('/bonjour/{utilisateur}', name:'app_bonjour')]
    public function bjr($utilisateur):Response{
        return new Response($utilisateur);
    }

    #[Route('/calcul/{nbr1}+{nbr2}/result', name:'app_calcul')]
    public function ajouterNombre($nbr1,$nbr2):Response{
        if($nbr1 != (int)$nbr1 || $nbr2 != (int)$nbr2){
            return new Response("L'une des 2 valeurs n'est pas un nombre.");
        }
        $result = $nbr1 + $nbr2;
        return new Response("La somme des 2 nombres est: ".($result));
    }

    #[Route('/calculate/{nbr1}/{operator}/{nbr2}/result', name:'app_calculate')]
    public function calculate($nbr1,$nbr2,$operator):Response{
        $operation = "";
        $result = 0;
        if($nbr1 != (int)$nbr1 && $nbr2 != (int)$nbr2){
            return new Response("Il n'y a aucune valeur... :(");
        } else if($nbr1 != (int)$nbr1){
            return new Response("La première valeur n'est pas un nombre.");
        } else if($nbr2 != (int)$nbr2){
            return new Response("La seconde valeur n'est pas un nombre.");
        }
        switch($operator){
            case "add": 
                $operation = "addition";
                $result = $nbr1 + $nbr2;
                break;
            case "sub": 
                $operation = "soustracton";
                $result = $nbr1 - $nbr2;
                break;
            case "multi": 
                $operation = "multiplication";
                $result = $nbr1 * $nbr2;
                break;
            case "div": 
                $operation = "division";
                if ($nbr1 != 0 && $nbr2 != 0){
                    $result = $nbr1 / $nbr2;
                } else {
                    $result = "pas possible car on peut pas diviser par 0";
                }
                break;
            default:
                $operation = "erreur default";
                $result = 0;
                break;
        }
        return new Response("Le résultat de cette ".($operation). " est " .($result));
    }

}