<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => ['class' => 'input'], //attr -> attributs
                'empty_data' => '',
                'label' => 'Saisir le nom: ',
                'label_attr' => ['class' => 'label_input'],
                'required' => true
            ])
            ->add('firstName', TextType::class,[
                'attr' => ['class' => 'input'],
                'empty_data' => '',
                'label' => 'Saisir le prénom: ',
                'label_attr' => ['class' => 'label_input'],
                'required' => true
            ])
            ->add('mail', EmailType::class,[
                'attr' => ['class' => 'input'],
                'empty_data' => '',
                'label' => 'Saisir le mail: ',
                'label_attr' => ['class' => 'label_input'],
                'required' => true
            ])
            ->add('pssword', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Les mdp ne correspondent pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'empty_data' => '',
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
            ])
            ->add('img', TextType::class,[
                'attr' => ['class' => 'input'],
                'empty_data' => '',
                'label' => 'image: ',
                'label_attr' => ['class' => 'label_input'],
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
