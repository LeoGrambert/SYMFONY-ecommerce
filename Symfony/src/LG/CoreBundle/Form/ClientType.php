<?php

namespace LG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom de famille',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Pays de résidence',
                'preferred_choices' => ['France'],
                'choices'  => [
                    'France' => 'France',
                    'Algérie' => 'Algérie',
                    'Allemagne' => 'Allemagne',
                    'Angleterre' => 'Angleterre',
                    'Australie' => 'Australie',
                    'Autriche' => 'Autriche',
                    'Belgique' => 'Belgique',
                    'Biélorussie' => 'Biélorussie',
                    'Brésil' => 'Brésil',
                    'Bulgarie' => 'Bulgarie',
                    'Canada' => 'Canada',
                    'Chine' => 'Chine',
                    'Chypre' => 'Chypre',
                    'Croatie' => 'Croatie',
                    'Danemark' => 'Danemark',
                    'Egypte' => 'Egypte',
                    'Espagne' => 'Espagne',
                    'Estonie' => 'Estonie',
                    'Etats-Unis' => 'Etats-Unis',
                    'Finlande' => 'Finlande',
                    'Grèce' => 'Grèce',
                    'Hongrie' => 'Hongrie',
                    'Inde' => 'Inde',
                    'Irlande' => 'Irlande',
                    'Islande' => 'Islande',
                    'Italie' => 'Italie',
                    'Japon' => 'Japon',
                    'Maroc' => 'Maroc',
                    'Mexique' => 'Mexique',
                    'Norvège' => 'Norvège',
                    'Pays-Bas' => 'Pays-Bas',
                    'Pologne' => 'Pologne',
                    'Portugais' => 'Portugais',
                    'Russie' => 'Russie',
                    'Suède' => 'Suède',
                    'Suisse' => 'Suisse',
                    'Tunisie' => 'Tunisien',
                    'Autre' => 'Autre'
                ]
            ])
            ->add('birthDate', BirthdayType::class, [
                'label' => 'Date de naissance',
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LG\CoreBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lg_corebundle_client';
    }


}
