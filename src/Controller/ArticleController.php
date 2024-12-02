<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
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
    public function articleSearchResults(Request $request, ArticleRepository $articleRepository): Response
    {
        // Récupération du paramètre search dans l'url
        $search = $request->query->get('search');

        // Appel à la méthode depuis ArticleRepository qui interroge la bdd et
        // récupère les articles correspondant à la recherche
        $articles = $articleRepository->search($search);

        // On crée un nouvier fichier twig et on retourne notre méthode vers
        // Cette page
        return $this->render('article_search_results.html.twig', [
            'search' => $search, 'articles' => $articles
            // On récupère bien la varibale $articles pour pouvoir l'utiliser dans notre twig
        ]);
    }

    #[Route('/article/create', 'article_create')]
    public function createArticle(EntityManagerInterface $entityManager, Request $request): Response
    {

        // Création d'une nouvelle instance de l'entité Article
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        // Génération d'un formulaire basé sur la classe 'ArticleType'
        // Cette classe définit la structure et les champs du formulaire

        // Cette nouvelle méthode, récupère les données de la requête
        $form->handleRequest($request);

        // On vérifie si le formulaire à été envoyé
        if ($form->isSubmitted() ) {
            // On met de manière auto la date de création car on en veut pas
            // qu'elle soit choisie par le user
            $article->setCreatedAt(new \DateTime());
            // On sauvegarde et on envoie
            $entityManager->persist($article);
            $entityManager->flush();

            // Redirection vers une autre page
            return $this->redirectToRoute('articles_list');
        }

        $formView = $form->createView();
        // Prépare la vue du formulaire pour qu'elle puisse être affichée dans le fichier Twig

        return $this->render('article_create.html.twig',[
            // On passe la variable $formView à notre twg
            'formView' => $formView,
        ]);
    }


    #[Route('/article/remove/{id}', 'article_remove', ['id' => '\d+'])]
    // Nouvelle route et nouvelle méthode pour supprimer un article depuis notre BDD
        // Qui possède bien un ID valide/existant
    public function removeArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, int $id)
    {

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
    public function updateArticle(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, int $id, Request $request): Response
    {
        // On récupère l'article correspondant à l'ID
        $article = $articleRepository->find($id);

        // Création du formulaire basé sur ArticleType, pré-rempli avec les données de l'article
        $form = $this->createForm(ArticleType::class, $article);

        // Gestion de la requête (remplissage automatique du formulaire avec les données POST)
        $form->handleRequest($request);

        // Vérification si le formulaire est soumis
        if ($form->isSubmitted()) {
            // Sauvegarde des modifications dans la base de données
            $entityManager->persist($article);
            $entityManager->flush();

            // Redirection vers une autre page
            return $this->redirectToRoute('articles_list');
        }

        // Génération de la vue du formulaire
        $formView = $form->createView();

        return $this->render('article_update.html.twig', [
            // On passe le formulaire à Twig
            'formView' => $formView,
            'article' => $article,
        ]);
    }


}