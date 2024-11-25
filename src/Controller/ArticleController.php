<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/articles', name: 'articles_list')]
    public function articles() {

        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'As de Coeur',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/f/fc/01_of_hearts_A.svg',
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'As de pique',
                'image' => 'https://i.pinimg.com/236x/83/c4/0e/83c40ecd6b38dfb399ad4c892e515036.jpg',
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'As de carreau',
                'image' => 'https://t3.ftcdn.net/jpg/00/04/08/28/360_F_4082899_Hz0grxupOzcTI71evDTzZkByKnd7Q2yY.jpg',
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'As de trèfle',
                'image' => 'https://www.tiragecarte.fr/images/cartes-classiques/1-trefle.jpg',
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Content of article 5',
                'image' => 'https://m.media-amazon.com/images/I/61JAHOF6l1L.jpg',
            ]

        ];
        return $this->render('articles_list.html.twig', [
            'articles' => $articles
        ]);
    }
}