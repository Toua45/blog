<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Mon titre',
                'attr' => [
                    'placeholder' => 'Mon titre' //attr permet de donner des attribut html, ici un placeholder
                ]
            ])
            ->add('imageFile', VichImageType::class,
            [
            'required' => false,
        ])
//            ->add('content', TextareaType::class, [
//                'attr' => [
//                    'rows' => 10, //perùet d'agrandir la taille du content
//                    ]
//            ])
                ->add('content', CKEditorType::class, []) //permet d'intégrer le wysiwyg

            ->add('date', DateTimeType::class)
        ->add('category', EntityType::class, [ //permet de faire un choisetype qui va chercher les infos dans une bdd
            'class' => Category::class,
            'choice_label' => 'fullCategory' //va prendre le getName de l'entitté Category
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
