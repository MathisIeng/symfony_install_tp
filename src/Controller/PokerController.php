<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokerController extends AbstractController {
    #[Route('/poker', name: 'poker')]
    public function poker() {

        // On appelle la méthode createFromGlobals()
        // afin de remplir la variable $request de toutes les données
        // de requête différentes
        $request = Request::createFromGlobals();
        // Propriété query qui nous permet
        // de récupérer les données GET
        $age = $request->query->get('age');

        // Permet d'afficher sur notre page la valeur associé à notre URL
        // avec ?age=25 par exemple
        echo ("Toi l'utilisateur là, tu as {$age} ans");

        // Vérification de l'âge pour afficher un message approprié
        if ($age < 18) {
            return $this->render('poker/pokerNoAccess.html.twig');
        } else {
            return $this->render('poker/pokerAccess.html.twig');
        }
    }
}