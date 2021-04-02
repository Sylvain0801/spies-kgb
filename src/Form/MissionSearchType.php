<?php

namespace App\Form;

use App\Entity\Nationality;
use App\Entity\Statute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statute', EntityType::class, [
                'class' => Statute::class,
                'choice_label' => 'name',
                'placeholder' => '--Statut--',
                'label' => false,
                'required' => false
            ])
            ->add('nationality', EntityType::class, [
                'class' => Nationality::class,
                'choice_label' => 'country',
                'placeholder' => '--Pays--',
                'label' => false,
                'required' => false
            ])
            ->add('words', SearchType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Rechercher'],
                'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
