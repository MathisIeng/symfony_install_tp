<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/articles', name: 'articles_list')]
    public function articles() {

        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Dead head',
                'image' => 'https://i.makeagif.com/media/2-18-2023/HPLAcW.gif',
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Miel Pops',
                'image' => 'https://media.tenor.com/duGh7BkKc3gAAAAM/bumble-bee-sus.gif',
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Ah bon ?',
                'image' => 'https://i.gifer.com/74VE.gif',
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Choqué',
                'image' => 'https://media.tenor.com/7RJbuufuLNkAAAAM/tik-tok-tiktok-meme.gif',
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Rizz',
                'image' => 'https://media.tenor.com/ElJBqX9FyNgAAAAM/sockcord-sock.gif',
            ]

        ];
        return $this->render('articles_list.html.twig', [
            'articles' => $articles
        ]);
    }

    // Dans la même classe on crée une nouvelle méthode qui va afficher
    // l'article en entier selon l'id récupérer dans l'url grâce au GET
    #[Route('/article', name: 'article_show')]
    public function showArticle() {
        // Nouvelle instance Request afin de récupérer les données
        // de la requête HTTP
       $request = Request::createFromGlobals();
       // Création variable $id pour récupérer la donnée GET "id"
       $id = $request->query->get('id');

        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Dead head',
                'image' => 'https://i.makeagif.com/media/2-18-2023/HPLAcW.gif',
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Miel Pops',
                'image' => 'https://media.tenor.com/duGh7BkKc3gAAAAM/bumble-bee-sus.gif',
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Ah bon ?',
                'image' => 'https://i.gifer.com/74VE.gif',
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Choqué',
                'image' => 'https://media.tenor.com/7RJbuufuLNkAAAAM/tik-tok-tiktok-meme.gif',
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Rizz',
                'image' => 'https://media.tenor.com/ElJBqX9FyNgAAAAM/sockcord-sock.gif',
            ]

        ];

        // On donne a notre nouvelle variable la valeur null
        $articleFound = null;

        // On crée une boucle qui va parcourir tout les $article du tableau
        // $articles, si l'id d'un des $article correspond à notre variable $id
        // Donc la donnée récupérer en GET alors $articleFound affiche l'article
        // correspondant
        foreach ($articles as $article) {
            if ($article['id'] === (int) $id) {
                $articleFound = $article;
            }
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
}