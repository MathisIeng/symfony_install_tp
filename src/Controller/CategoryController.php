<?php

// DATABASE_URL="mysql://root:root@localhost:8889/piscine_sf_install?charset=utf8mb4"
// La chaîne de connexion avec la BDD (nom user et mdp)

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Grâce au terminal et certaines lignes de commandes, on a crée une entité
// Category, on lui a assigné des propriétées et son Repository à aussi été crée
// On a aussi fait une migration de cette entité sur la BDD
// Nouvelle class ici, on lui fait hériter AbstractController pour utiliser la fonction render
class CategoryController extends AbstractController
{
    // La route me permettant de choisir le chemin de l'url vers lequel je pourrai
    // accéder à la page en question
    #[Route('/categories', name: 'categories_list')]
    // Méthode qui va nous permettre d'afficher toutes les catégories d'un coup
        // On passe mtn en paramètre le repository en question (autowire)
    public function categoryList(CategoryRepository $categoryRepository)
    {

        // Création de varaible afin de lister toutes les catégories existantes
        // Depuis ma BDD (ORM), avec la méthode findAll
        $categories = $categoryRepository->findAll();

        return $this->render('categories_list.html.twig', [
            'categories' => $categories
        ]);
    }

    // Même principe que notre première méthode mais ici pour récupérer précisement
    // 1 catégorie par rapport à l'id
    // Le requirements sert à préciser que c'est un integer qu'on doit rentrer afin
    // que ce le code de la méthode soit éxecuter
    #[Route('/categorie/{id}', name: 'categorie_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function categoryById(CategoryRepository $categoryRepository, $id)
    {

        $categorie = $categoryRepository->find($id);

        // Condition, si la category n'est pas trouvé, on redirige vers une page 404
        if (!$categorie) {
            return $this->redirectToRoute('not-found');
        }

        return $this->render('categorie_show.html.twig', [
            'categorie' => $categorie
        ]);
    }

    #[Route('/category/created', 'category_created')]
    public function createCategory(EntityManagerInterface $entityManager, Request $request): Response
    {

        // Création d'une nouvelle instance de l'entité Category
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        // Génération d'un formulaire basé sur la classe 'CategoryType'
        // Cette classe définit la structure et les champs du formulaire

        // Cette nouvelle méthode, récupère les données de la requête
        $form->handleRequest($request);

        // On vérifie si le formulaire à été envoyé
        if ($form->isSubmitted()) {
            // On sauvegarde et on envoie
            $entityManager->persist($category);
            $entityManager->flush();

            // Redirection vers une autre page
            return $this->redirectToRoute('categories_list');
        }

        $formView = $form->createView();
        // Prépare la vue du formulaire pour qu'elle puisse être affichée dans le fichier Twig

        return $this->render('category_create.html.twig', [
            // On passe la variable $formView à notre twg
            'formView' => $formView,
        ]);
    }

    #[Route('/category/remove/{id}', 'category_removed', ['id' => '\d+'])]
    public function categoryRemove(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, int $id)
    {

        // dd('test');

        $category = $categoryRepository->find($id);

        if (!$category) {
            return $this->redirectToRoute('not-found');
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('categories_list');
    }

    #[Route('/category/update/{id}', 'category_update', ['id' => '\d+'])]
    // Nouvelle méthode pour mettre à jour une catégorie en récupérant l'id correspondant
        // à celle ci
    public function updateCategory(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, int $id, Request $request)
    {

        // Ici, on viens trouver avec la fonction find l'id de la catégorie qu'on veut
        // modifier via le repository
        $category = $categoryRepository->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        // Génération d'un formulaire basé sur la classe 'CategoryType'
        // Cette classe définit la structure et les champs du formulaire

        // Cette nouvelle méthode, récupère les données de la requête
        $form->handleRequest($request);

        // On vérifie si le formulaire à été envoyé
        if ($form->isSubmitted()) {
            // On sauvegarde et on envoie
            $entityManager->persist($category);
            $entityManager->flush();

            // Redirection vers une autre page
            return $this->redirectToRoute('categories_list');
        }

        $formView = $form->createView();
        // Prépare la vue du formulaire pour qu'elle puisse être affichée dans le fichier Twig

        return $this->render('category_update.html.twig', [
            // On passe la variable $formView à notre twg
            'formView' => $formView,
        ]);
    }
}