<?php

namespace AppBundle\Form;

use AppBundle\Entity\CategoryMovie;
use AppBundle\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('synopsis', TextType::class)
            ->add('releaseDate', DateType::class)
            ->add('categoryMovie', EntityType::class, [
                'class' => CategoryMovie:: class,
                'choice_label' => 'name'
            ])
            ->add('image', FileType::class, array('label' => 'Image JPG, PNG'))

            ->add('save', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Movie::class,
        ));
    }
}