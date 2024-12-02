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
        // La méthode render de classe AbstractController récupère
        // le fichier twig passé en paramètre dans le dossier template
        // ELle le convertit en HTML et crée une réponse valide
        // En status HTTP 200, et en body le HTML généré
        return $this->render('home.html.twig');
    }
}

// TOUTES LES LIGNES DE COMMANDE NECESSAIRES POUR LE PROJET

// Installez symfony : composer create-project symfony/skeleton nomduprojet
// apache : composer require symfony/apache-pack
// Annotations : composer require annotations
// Crée un controller : bin/console make:controller NomDuController

// DOCTRINE : composer require symfony/orm-pack - compose require --dev symfony/maker-bundle

// BDD : php bin/console doctrine:database:create

// ENTITY : php bin/console make:entity NomDeEntité
// php bin/console make:migration
// php bin/console doctrine:igrations:migrate

// FORMULAIRE : bin/console make:form