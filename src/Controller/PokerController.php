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

        return new Response("<h1>Bienvenue à la table de poker !</h1>");
    }
}