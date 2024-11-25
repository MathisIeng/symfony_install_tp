<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokerController
{
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
        var_dump($age);

        // Vérification de l'âge pour afficher un message approprié
        if ($age < 18) {
            return new Response("<p>Erreur : Vous devez avoir 18 ans ou plus pour participer au Poker.</p>");
        } else {
            return new Response("<p>Bienvenue sur le meilleur site de Poker au monde !</p>");
        }

        return new Response("<h1>Bienvenue à la table de poker !</h1>");
    }
}