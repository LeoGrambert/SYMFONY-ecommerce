<?php

namespace LG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('lastName', TextType::class)
            ->add('firstName', TextType::class)
            ->add('country', ChoiceType::class, array(
                'choices'  => array(
                    'Allemagne' => 'Allemagne',
                    'Angleterre' => 'Angleterre',
                    'Espagne' => 'Espagne',
                    'Etats-Unis' => 'Etats-Unis',
                    'France' => 'France',
                    'Italie' => 'Italie',
                    'Portugais' => 'Portugais',
                    'Autre' => 'Autre'
                )
            ))
            ->add('birthDate', BirthdayType::class)
            ->add('reducedPrice', CheckboxType::class, ['required' => false])
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
