<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Création d'une classe HomeController (même nom que celui du fichier)
class HomeController {

    // # pour définir la route de notre url, ici c'est la page d'accueil
    #[Route('/', name: 'home')]
    // On crée une méthode
    public function home() {
        // Retourne une nouvelle instance de la classe Response
        // Qui renvoie du HTML, son contenu est dans la réponse HTTP
        return new Response('<h1>Bienvenue à tous les loulous, vous êtes sur le site de Siphano !</h1>');
    }
}