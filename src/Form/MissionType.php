<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Hideout;
use App\Entity\Mission;
use App\Entity\Nationality;
use App\Entity\Speciality;
use App\Entity\Statute;
use App\Entity\Target;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['rows' => 12,
                        'style' => 'resize:none'
                ]
            ])
            ->add('code_name', TextType::class, ['label' => 'Nom de code'])
            ->add('type', TextType::class, ['label' => 'Type'])
            ->add('start_date', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text'
                ])
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text'
                ])
            ->add('nationality', EntityType::class, [
                'class' => Nationality::class,
                'choice_label' => 'country',
                'label' => 'Pays',
                'placeholder' => '--Liste pays--'
                ])
            ->add('statute', EntityType::class, [
                'class' => Statute::class,
                'choice_label' => 'name',
                'label' => 'Statut',
                'placeholder' => '--Liste statuts--'            
                ])
            ->add('speciality', EntityType::class, [
                'class' => Speciality::class,
                'choice_label' => 'name',
                'label' => 'Spécialité',
                'placeholder' => '--Liste spécialités--'            
                ])
            ->add('agent', EntityType::class, [
                'class' => Agent::class,
                'placeholder' => '--Liste agents--',
                'label' => 'Agents',
                'multiple' => true,
            ])
            ->add('target', EntityType::class, [
                'class' => Target::class,
                'placeholder' => '--Liste cibles--',
                'required' => false,
                'label' => 'Cibles',
                'multiple' => true,
            ])
            ->add('contact', EntityType::class, [
                'class' => Contact::class,
                'placeholder' => '--Liste contacts--',
                'required' => false,
                'label' => 'Contacts',
                'multiple' => true,
            ])
            ->add('hideout', EntityType::class, [
                'class' => Hideout::class,
                'placeholder' => '--Liste planques--',
                'required' => false,
                'label' => 'Planques',
                'multiple' => true,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
