<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// Création d'une classe HomeController (même nom que celui du fichier)
class HomeController extends AbstractController {

    // # pour définir la route de notre url, ici c'est la page d'accueil
    #[Route('/', name: 'home')]
    // On crée une méthode
    public function home() {

        return $this->render('home.html.twig');
    }
}