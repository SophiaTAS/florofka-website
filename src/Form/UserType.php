<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email' , EmailType::class)
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'ROLE_ADMIN' => 'ROLE_ADMIN',
            //         'ROLE_USER' => 'ROLE_USER'
            //         // Ajoutez autant d'options que nécessaire
            //     ],
            //     'placeholder' => 'Sélectionner un Role', // Texte par défaut (optionnel)
            //     'required' => true,
            //     'attr' => [
            //         'class' => 'form-select mt-3 mb-3 ms-3 me-3' // Utilisez la classe Bootstrap 'form-select' pour styliser la balise de sélection
            //     ],
            // ] )
            ->add('password', PasswordType::class)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
