<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request): Response
    {
        // On initialise le message de confirlmation a null
        $confirmation = null;

        // On pose une condition, seulement si la requête est de type POST
        // On crée trois variables, récupérer le nom, le message et la confirmation qui
        // contient le nom et message
        // Cela nous permet avec twig de récupérer seulement le message de confirmation
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $message = $request->request->get('message');
            $confirmation = "Merci $name, votre message a été envoyé : $message";
        }

        return $this->render('contact.html.twig',
            ['confirmation' => $confirmation]);
    }
}
