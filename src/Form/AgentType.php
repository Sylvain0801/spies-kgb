<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Nationality;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identification_code', IntegerType::class, ['label' => 'Code d\'identification'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('date_of_birth', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text'
                ])
            ->add('nationality', EntityType::class, [
                'class' => Nationality::class,
                'choice_label' => 'name',
                'label' => 'Nationalité',
                'placeholder' => '--Liste nationalités--'            
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
