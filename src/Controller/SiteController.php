<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/', name: 'app_site')]
    public function index(): Response
    {
        return $this->render('site/index.html.twig');
    }

    #[Route('/galerie', name: 'app_site_portfolio')]
    public function showPortfolio(): Response
    {
        return $this->render('site/portfolio.html.twig');
    }
}