<?php

namespace App\Form;

//import des modules
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GestionUserType extends AbstractType
{
    //fonction qui construit le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options):void {
        $builder
        ->add('email', EmailType::class,[
        'attr' => ['class' => 'formulaire'],
        'label'=> 'Mail',
        'required' => true,
        ])

        ->add('password', PasswordType::class, [
        'attr' => ['class' => 'formulaire'],
        'label'=> 'Mot de passe',
        'required' => true,
        ])

        ->add('Ajouter', SubmitType::class) ;
    }
}