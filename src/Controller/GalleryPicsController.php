<?php

namespace App\Controller;

use App\Entity\GalleryPics;
use App\Form\GalleryPicsType;
use App\Repository\GalleryPicsRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gallery/pics')]
class GalleryPicsController extends AbstractController
{
    #[Route('/', name: 'app_gallery_pics_index', methods: ['GET'])]
    public function index(GalleryPicsRepository $galleryPicsRepository): Response
    {
        return $this->render('gallery_pics/index.html.twig', [
            'gallery_pics' => $galleryPicsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gallery_pics_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PictureService $pictureService): Response
    {

        $form = $this->createForm(GalleryPicsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //On recupere les images
            $images = $form->get('name')->getData();
            $category = $form->get('category')->getData();

            foreach($images as $image){
                //on definie le dossier de destination
                $folder = 'galerie';
                // On appelle le service d'ajout
                $fichier = $pictureService->add($image, $folder, 400, 250);

                $img = new GalleryPics();
                $img->setCategory($category);
                $img->setName($fichier);
                $entityManager->persist($img);
            }

            
            $entityManager->flush();

            return $this->redirectToRoute('app_gallery_pics_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gallery_pics/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gallery_pics_show', methods: ['GET'])]
    public function show(GalleryPics $galleryPic): Response
    {
        return $this->render('gallery_pics/show.html.twig', [
            'gallery_pic' => $galleryPic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gallery_pics_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GalleryPics $galleryPic, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GalleryPicsType::class, $galleryPic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gallery_pics_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gallery_pics/edit.html.twig', [
            'gallery_pic' => $galleryPic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gallery_pics_delete', methods: ['POST'])]
    public function delete(Request $request, GalleryPics $galleryPic, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galleryPic->getId(), $request->request->get('_token'))) {
            $entityManager->remove($galleryPic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gallery_pics_index', [], Response::HTTP_SEE_OTHER);
    }
}
