<?php

namespace App\Form;

use App\Entity\GalleryPics;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

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
                    'class' => 'form-select' // Utilisez la classe Bootstrap 'form-select' pour styliser la balise de sélection
                ],
            ])
            ->add('name', DropzoneType::class,  [
                'attr' => [
                    'placeholder' => 'Deposer une ou plusieurs images ou cliquer pour rechercher'
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
