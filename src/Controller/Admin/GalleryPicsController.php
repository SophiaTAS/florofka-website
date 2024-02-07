<?php

namespace App\Controller\Admin;

use App\Entity\GalleryPics;
use App\Form\GalleryPicsType;
use App\Repository\GalleryPicsRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class GalleryPicsController extends AbstractController
{
    #[Route('/galerie/pics', name: 'app_gallery_pics_index', methods: ['GET'])]
    public function index(GalleryPicsRepository $galleryPicsRepository): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        return $this->render('admin/gallery_pics/index.html.twig', [
            'gallery_pics' => $galleryPicsRepository->findAll(),
        ]);
    }

    #[Route('/galerie/new', name: 'app_gallery_pics_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PictureService $pictureService): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

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

            $this->addFlash('success', 'Image(s) ajoutée avec succés');

            return $this->redirectToRoute('app_gallery_pics_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/gallery_pics/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/galerie/{id}', name: 'app_gallery_pics_show', methods: ['GET'])]
    public function show(GalleryPics $galleryPic): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        return $this->render('admin/gallery_pics/show.html.twig', [
            'gallery_pic' => $galleryPic,
        ]);
    }

    #[Route('/galerie/{id}', name: 'app_gallery_pics_delete', methods: ['POST'])]
    public function delete(PictureService $pictureService, Request $request, GalleryPics $galleryPic, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        
        if ($this->isCsrfTokenValid('delete'.$galleryPic->getId(), $request->request->get('_token'))) {
            $nom = $galleryPic->getName();

            if($pictureService->delete($nom, 'galerie', 400, 250)){

                $entityManager->remove($galleryPic);
                $entityManager->flush();

                $this->addFlash('success', 'Image supprimée avec succés');

                return $this->redirectToRoute('app_gallery_pics_index');
            }

            $this->addFlash('danger', 'Erreur de suppression');

            return $this->redirectToRoute('app_gallery_pics_index');
            
        }

        return $this->redirectToRoute('app_gallery_pics_index', [], Response::HTTP_SEE_OTHER);
    }
}
