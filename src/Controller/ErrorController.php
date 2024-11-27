<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/not-found', name: 'not-found')]
    public function notFound(): Response {

        $view = $this->renderView('404.html.twig');

        return new Response($view, 404);
    }
}