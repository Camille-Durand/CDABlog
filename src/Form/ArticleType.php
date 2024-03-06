<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use DateTimeInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'attr' => ['class' => 'input'],
                'empty_data' => '',
                'label' => 'Titre: ',
                'label_attr' => ['class' => 'label_input'],
                'required' => true
            ])

            ->add('content', TextType::class,[
                'attr' => ['class' => 'input'],
                'empty_data' => '',
                'label' => 'Contenu: ',
                'label_attr' => ['class' => 'label_input'],
                'required' => true
            ])

            ->add('createAt', null, [
                'widget' => 'single_text',
            ])

            ->add('imgArticle', TextType::class,[
                'attr' => ['class' => 'input'],
                'empty_data' => '',
                'label' => 'Image (URL): ',
                'label_attr' => ['class' => 'label_input'],
                'required' => true
            ])

            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])

            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
