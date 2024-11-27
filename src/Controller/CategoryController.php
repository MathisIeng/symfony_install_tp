<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// Grâce au terminal et certaines lignes de commandes, on a crée une entité
// Category, on lui a assigné des propriétées et son Repository à aussi été crée
// On a aussi fait une migration de cette entité sur la BDD
// Nouvelle class ici, on lui fait hériter AbstractController pour utiliser la fonction render
class CategoryController extends AbstractController
{
    // La route me permettant de choisir le chemin de l'url vers lequel je pourrai
    // accéder à la page en question
    #[Route('/categories', name: 'category_list')]
    // Méthode qui va nous permettre d'afficher toutes les catégories d'un coup
    // On passe mtn en paramètre le repository en question (autowire)
    public function categoryList(CategoryRepository $categoryRepository) {

        // Création de varaible afin de lister toutes les catégories existantes
        // Depuis ma BDD (ORM)
        $categories = $categoryRepository->findAll();

        return $this->render('category_list.html.twig', [
            'categories' => $categories
        ]);
    }

    // Même principe que notre première méthode mais ici pour récupérer précisement
    // l'id d'une catégorie
    #[Route('/categorie/{id}', name: 'category_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function categoryById(CategoryRepository $categoryRepository, $id) {

        $category = $categoryRepository->find($id);

        return $this->render('category_show.html.twig', [
            'category' => $category
        ]);
    }
}