<?php

namespace App\Form;

use App\Entity\GalleryPics;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryPicsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Bouquet' => 'Bouquet',
                    'Composition' => 'Composition',
                    'Mariage' => 'Mariage',
                    'Hommage' => 'Hommage'
                    // Ajoutez autant d'options que nécessaire
                ],
                'placeholder' => 'Sélectionner une catégorie', // Texte par défaut (optionnel)
                'required' => true,
                'attr' => [
                    'class' => 'form-select mt-3 mb-3 ms-3 me-3' // Utilisez la classe Bootstrap 'form-select' pour styliser la balise de sélection
                ],
            ])
            ->add('name', FileType::class,  [
                'label' => 'Selectionner une ou plusieurs images',
                'multiple' => true,
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control mt-3 mb-3 ms-3 me-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GalleryPics::class,
        ]);
    }
}
