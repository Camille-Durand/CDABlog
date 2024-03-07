<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\EmailService;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(EmailService $emailService): Response
    {
        $subject = "Veuillez activer votre compte stv";
        $body = "Cliquez sur le lien tkt c'est pas une arnaque";
        $content = $this->render("email/index.html.twig", [
            'subject' => $subject,
            'body' => $body,
        ]);
        $emailService->sendEmail("mail à add ici", $subject, $content->getContent());
        return new Response("Le mail a bien été envoyé!");
    }
}
