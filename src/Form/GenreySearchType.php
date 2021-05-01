<?php

namespace App\Form;

use App\Entity\GenreSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Genre;


class GenreySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Genre')
            ->add('Genre',EntityType::class,['class' =>Genre::class,
 'choice_label' => 'titre' ,
 'label' => 'Genre' ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GenreSearch::class,
        ]);
    }
}
