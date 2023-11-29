<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Location;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut')
            ->add('date_retour')
            ->add('prix')
            ->add('voiture')
            ->add('client', EntityType::class, [
                "class" => Client::class,
                "choice_label" => "nom",
                "expanded" => false,
                "multiple" => false
            ])
            ->add('voiture', EntityType::class, [
                "class" => Voiture::class,
                "choice_label" => "serie",
                "expanded" => false,
                "multiple" => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
