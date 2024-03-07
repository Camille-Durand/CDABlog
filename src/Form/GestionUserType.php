<?php

namespace App\Form;

//import des modules
use App\Entity\GestionUser;
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
        'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-4'],
        'label'=> 'Mail',
        'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
        'required' => true,
        ])

        ->add('password', PasswordType::class, [
        'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-4'],
        'label'=> 'Mot de passe',
        'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
        'required' => true,
        ])

        ->add('Ajouter', SubmitType::class) ;
    }
}