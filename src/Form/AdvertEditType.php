<?php

namespace App\Form;

use App\Entity\Advert;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('author')
            ->remove('date')
        ;
    }

    public function getParent()
    {
        return AdvertType::class;
    }
    
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => Advert::class,
//        ]);
//    }
}
