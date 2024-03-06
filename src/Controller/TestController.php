<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/affichernom/{nom}', name: 'app_testnom')]
    public function afficher($nom): Response
    {
        return $this->render('test/index.html.twig', [
            'nom' => $nom,
        ]);
    }

    #[Route('/calculette/{nbr1}/{operator}/{nbr2}/resultat', name:'app_calculette')]
    public function calculate($nbr1,$nbr2,$operator):Response{
        $operation = "";
        $result = 0;
        switch($operator){
            case "add": 
                $operation = "+";
                $result = $nbr1 + $nbr2;
                break;
            case "sub": 
                $operation = "-";
                $result = $nbr1 - $nbr2;
                break;
            case "multi": 
                $operation = "*";
                $result = $nbr1 * $nbr2;
                break;
            case "div": 
                $operation = "/";
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
        return $this->render('test/index.html.twig', [
            'nbr1' => $nbr1,
            'nbr2' => $nbr2,
            'operation' => $operation,
            'result' => $result,
        ]);
    }

    #[Route('/rendercalcul/{nbr1}/{operator}/{nbr2}/result', name:'app_rendercalcul')]
    public function rendercalcul($nbr1,$nbr2,$operator):Response{
        return $this->render('test/index.html.twig', [
            'nbr1' => $nbr1,
            'nbr2' => $nbr2,
            'operator' => $operator
        ]);
    }
}
