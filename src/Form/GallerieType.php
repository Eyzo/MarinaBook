<?php

namespace App\Form;

use App\Entity\GalleriePhoto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GallerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('image',PhotosType::class,array(
                'label' => 'largeur d\'au minimum 1920 px conseillé pour la qualitée de l\'image'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GalleriePhoto::class,
        ]);
    }
}
