<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    // methods est une sécurité supplémentaire qui accepte dans ce cas la
    // que les requêtes en GET ou POST
    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request): Response
    {
        // On initialise le message de confirlmation a null
        $confirmation = null;
        $error = null;

        // On pose une condition, seulement si la requête est de type POST
        // On crée trois variables, récupérer le nom, le message et la confirmation qui
        // contient le nom et message
        // Cela nous permet avec twig de récupérer seulement le message de confirmation
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $message = $request->request->get('message');

            // Validation des champs
            if (strlen($name) < 3) {
                $error = "Le nom doit contenir au moins 3 caractères.";
            } elseif (strlen($message) < 10) {
                $error = "Le message doit contenir au moins 10 caractères.";
            } else {
                $confirmation = "Merci $name, votre message a été envoyé : $message";
            }
        }

        return $this->render('contact.html.twig',
            ['confirmation' => $confirmation,
            'error' => $error,
            ]);
    }
}
