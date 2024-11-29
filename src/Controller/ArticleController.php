<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/articles', name: 'articles_list')]
    // Grâce à l'autowire la classe ArticleRepository est instanciée
    public function articles(ArticleRepository $articleRepository): Response
    {

        // On récupère avec la méthode findAll, tout les articles
        // De notre BDD via la table article
        $articles = $articleRepository->findAll();

        return $this->render('articles_list.html.twig', [
            'articles' => $articles
        ]);
    }

    // Dans la même classe on crée une nouvelle méthode qui va afficher
    // l'article en entier selon l'id récupérer dans l'url grâce au GET
    // On ajoute a notre url {id} afin de récupérer l'id directement
    // dans mon url sans avoir besoin de faire ?id=""
    #[Route('/article/{id}', 'article_show', ['id' => '\d+'])]
    // Par contre je dois bien le rentrer en paramètre de ma méthode
        // Et symfony s'occupe du reste c'est magique
    public function showArticle(int $id, ArticleRepository $articleRepository): Response
    {

        $articleFound = $articleRepository->find($id);

        if (!$articleFound) {
            // Ici, si l'utilisateur essaie de trouver un article avec un id
            // qui n'est pas présent sur mon site, on le redirige vers 404
            return $this->redirectToRoute('not-found');
        }

        // dump($id, $articleFound); die;
        // Grâce a render une fonction de la classe AbstractController
        // Qu'on a récupérer avec l'héritage (classe propre a symfony)
        // ou on met en paramètre le fichier twig et un tableau
        // qui va afficher notre variable qui contient l'article trouvé en question
        return $this->render('article_show.html.twig', [
            'article' => $articleFound
        ]);
    }

    #[Route('/articles/search-results', name: 'article_search_results')]
    // Nouvelle route et méthode pour utiliser ce que Symfony applique lui même
        // Sans avoir besoin de crée nous même la nouvelle INSTANCE Request, on la met
        // en paramètre de notre méthode ainsi que notre variable (autowire)
        // De manière automatique
    public function articleSearchResults(Request $request): Response
    {
        $search = $request->query->get('search');

        // On crée un nouvier fichier twig et on retourne notre méthode vers
        // Cette page
        return $this->render('article_search_results.html.twig', [
            'search' => $search
        ]);
    }

    #[Route('/article/create', 'article_create')]
    public function createArticle(EntityManagerInterface $entityManager, Request $request): Response
    {

        // Si le formulaire a été soumis (requête POST)
        if ($request->isMethod('POST')) {
            // On récupère les données du formulaire
            $title = $request->request->get('title');
            $content = $request->request->get('content');
            $image = $request->request->get('image');


            // Je crée une instance de l'entité Article
            // et l'enregistre dans ma table article

            $article = new Article();
            // J'utilise les méthodes set pour associé une valeur
            // à chacune de mes propritétés
            $article->setTitle($title);
            // Affecte le titre qui à été soumis dans le form
            $article->setContent($content);
            // Définit le contenu de l'article
            $article->setImage($image);
            // Associe une image
            $article->setCreatedAt(new \DateTime());
            // Attribue la date et l'heure actuelles à l'article

            // Ajoute l'article à la gestion de Doctrine
            $entityManager->persist($article);
            // Exécute toutes les opérations en attente, ici on
            // Enregistre l'article dans la BDD
            $entityManager->flush();

            return $this->redirectToRoute('articles_list');
        }

        return $this->render('article_create.html.twig', [

        ]);
    }


    #[Route('/article/remove/{id}', 'article_remove', ['id' => '\d+'])]
    // Nouvelle route et nouvelle méthode pour supprimer un article depuis notre BDD
    // Qui possède bien un ID valide/existant
    public function removeArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager,int $id) {

        // dd('test');

        // Récupère l'article à supprimer
        $article = $articleRepository->find($id);

        if (!$article) {
            // Condition si l'article n'a pas été trouvé, on redirige vers notre page 404
            return $this->redirectToRoute('not-found');
        }

        // Nouvelle méthode remove qui permet de supprimer un article
        $entityManager->remove($article);
        // On utilise toujours la méthode flush pour bien envoyer notre suppression
        $entityManager->flush();

        return $this->redirectToRoute('articles_list');
    }

    #[Route('/article/update/{id}', 'article_update', ['id' => '\d+'])]
    // Nouvelle méthode pour mettre à jour un article en récupérant l'id correspondant
    // à celui ci
    public function updateArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager,int $id) {

        // Ici, on viens trouver avec la fonction find l'id de l'article qu'on veut
        // modifier via le repository
        $article = $articleRepository->find($id);

        // dd($article);

        // On met à jour le titre de mon article
        $article->setTitle('Article maj');
        // Egalement son contenu
        $article->setContent('maj incomming');

        // dd($article);

        if (!$article) {
            // On redirige vers une erreur 404 si l'id ne correspond a aucun article
            return $this->redirectToRoute('not-found');
        }

        // Avec persist, on pre sauvegarde la modification de notre article
        $entityManager->persist($article);
        // On push la maj à notre BDD
        $entityManager->flush();

        return $this->redirectToRoute('articles_list');

    }
}