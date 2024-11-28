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
    public function articles(ArticleRepository $articleRepository): Response {

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
    public function showArticle(int $id, ArticleRepository $articleRepository): Response {

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
    public function articleSearchResults(Request $request): Response {
        $search = $request->query->get('search');

        // On crée un nouvier fichier twig et on retourne notre méthode vers
        // Cette page
        return $this->render('article_search_results.html.twig', [
            'search' => $search
        ]);
    }

    #[Route('/article/create', 'create_article')]
    public function createArticle(EntityManagerInterface $entityManager) {

        // Je crée une instance de l'entité Article
        // et l'enregistre dans ma table article

        $article = new Article();
        // J'utilise les méthodes set pour associé une valeur
        // à chacune de mes propritétés
        $article->setTitle('Article 6');
        // Affecte le titre "Article 6"
        $article->setContent('Contenu article 6');
        // Définit le contenu de l'article
        $article->setImage("https://www.booska-p.com/wp-content/uploads/2018/03/drake-nothing-was-the-same-deluxe.jpg");
        // Associe une image
        $article->setCreatedAt(new \DateTime());
        // Attribue la date et l'heure actuelles à l'article

        // Ajoute l'article à la gestion de Doctrine
        $entityManager->persist($article);
        // Exécute toutes les opérations en attente, ici on
        // Enregistre l'article dans la BDD
        $entityManager->flush();

        return new Response('Article crée');
    }
}