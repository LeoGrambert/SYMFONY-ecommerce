<?php

namespace LG\CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateReservation', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                    'data-date-days-of-week-disabled' => '02',
                    'data-date-language' => 'fr',
                    'data-date-dates-disabled' => '01-01-2017, 17-04-2017, 01-05-2017, 08-05-2017, 25-05-2017, 05-06-2017, 14-07-2017, 15-08-2017, 01-11-2017, 11-11-2017, 25-12-2017'
                ]
            ))
            ->add('isDaily', ChoiceType::class, [
                'choices' => ['Journée' => 1, 'Demi-journée' => 0],
                'expanded' => true,
                'multiple' => false,
                'required' => true
            ])
            ->add('ticketNumber', ChoiceType::class, array(
                'choices'  => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' =>7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10
                )
            ))
            ->add('email', EmailType::class)
            ->add('clients', CollectionType::class, [
                'entry_type' => ClientType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('cgvAccept', ChoiceType::class, [
                'label' => 'Acceptez-vous les Conditions Générales de Vente ?',
                'choices' => ['Oui' => 1, 'Non' => 0],
                'expanded' => true,
                'multiple' => false,
                'required' => true

            ])
            ->add('stepThree', SubmitType::class, [
                'label' => 'Confirmer la commande'
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LG\CoreBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lg_corebundle_booking';
    }


}
