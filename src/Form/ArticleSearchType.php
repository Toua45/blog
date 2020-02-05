<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET') //permet de récupérer les infos en GET car par défaut en POST
            ->add('search', SearchType::class, [
                'required' => false,
            ])
            ->add('category', EntityType::class, [ // ajout du filtre par category
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false // permet de desactiver le token de securité
            // Configure your form options here
        ]);
    }
}
