<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CkeditorType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => ['class' => 'ckeditor'] // On ajoute la classe CSS
        ));
    }

    public function getParent() // On utilise l'héritage de formulaire
    {
        return TextareaType::class;
    }
}
