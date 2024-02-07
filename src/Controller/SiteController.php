<?php

namespace App\Controller;

use App\Repository\GalleryPicsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/', name: 'app_site')]
    public function index(GalleryPicsRepository $galleryPicsRepository): Response
    {
        $images = $galleryPicsRepository->findTwoPerCategory();

        return $this->render('site/index.html.twig', [
            'galerie' => $images
        ]);
    }

    #[Route('/galerie', name: 'app_site_portfolio')]
    public function showPortfolio(GalleryPicsRepository $galleryPicsRepository): Response
    {
        $images = $galleryPicsRepository->findAll();

        return $this->render('site/portfolio.html.twig', [
            'galerie' => $images
        ]);
    }
}
