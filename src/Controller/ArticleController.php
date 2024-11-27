<?php

namespace App\Controller;

use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/articles', name: 'articles_list')]
    public function articles(): Response {

        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'SCORPION',
                'image' => 'https://m.media-amazon.com/images/I/61l9Za1KRBL._UF1000,1000_QL80_.jpg',
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'MORE LIFE',
                'image' => 'https://www.thebackpackerz.com/wp-content/uploads/2017/03/More-Life-drake.jpg',
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'IF YOU',
                'image' => 'https://www.udiscovermusic.com/wp-content/uploads/2020/02/Drake-If-Youre-Reading-This-Its-Too-Late-album-cover-820-820x820.jpg',
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'SHADOW',
                'image' => 'https://cdn-images.dzcdn.net/images/cover/d46b7a8aa40ef7f09d71a03c2ce8edcd/0x1900-000000-80-0-0.jpg',
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'VIEWS',
                'image' => 'https://media.pitchfork.com/photos/5929b556ea9e61561daa6dca/1:1/w_450%2Cc_limit/2e5f0170.jpg',
            ]

        ];
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
    public function showArticle(int $id): Response {


        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'SCORPION',
                'image' => 'https://m.media-amazon.com/images/I/61l9Za1KRBL._UF1000,1000_QL80_.jpg',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'MORE LIFE',
                'image' => 'https://www.thebackpackerz.com/wp-content/uploads/2017/03/More-Life-drake.jpg',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'IF YOU',
                'image' => 'https://www.udiscovermusic.com/wp-content/uploads/2020/02/Drake-If-Youre-Reading-This-Its-Too-Late-album-cover-820-820x820.jpg',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'SHADOW',
                'image' => 'https://cdn-images.dzcdn.net/images/cover/d46b7a8aa40ef7f09d71a03c2ce8edcd/0x1900-000000-80-0-0.jpg',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'VIEWS',
                'image' => 'https://media.pitchfork.com/photos/5929b556ea9e61561daa6dca/1:1/w_450%2Cc_limit/2e5f0170.jpg',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ]

        ];

        // On donne a notre nouvelle variable la valeur null
        $articleFound = null;

        // On crée une boucle qui va parcourir tout les $article du tableau
        // $articles, si l'id d'un des $article correspond à notre variable $id
        // Donc la donnée récupérer en GET alors $articleFound affiche l'article
        // correspondant
        foreach ($articles as $article) {
            if ($article['id'] === $id) {
                $articleFound = $article;
            }
        }

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
}