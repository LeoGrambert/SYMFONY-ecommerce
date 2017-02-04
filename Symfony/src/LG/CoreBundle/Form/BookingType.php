<?php

namespace LG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookingType extends AbstractType
{

    private function getDisabledDate() {
        // todo cast date string into array
        // todo split each element into string
        // todo increment item and push it to the array
        // todo cast the array into string
        // todo return the string date formated
        return '01-01-2017,17-04-2017,01-05-2017,08-05-2017,25-05-2017,05-06-2017,14-07-2017,15-08-2017,01-11-2017,11-11-2017,25-12-2017';
    }
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
                    'data-date-start-date' => "0d",
                    'data-date-end-date' => '+364d',
                    'data-date-dates-disabled' => $this->getDisabledDate()
                ]
            ))
            ->add('isDaily', ChoiceType::class, [
                'choices' => [
                    'Journée' => true,
                    'Demi-journée' => false
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('ticketNumberNormal', ChoiceType::class, array(
                'label' => 'Tarif Normal',
                'choices'  => array(
                    '0' => 0,
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
            ->add('ticketNumberReduce', ChoiceType::class, array(
                'label' => 'Tarif Réduit',
                'choices'  => array(
                    '0' => 0,
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
//            ->add('clients', CollectionType::class, array (
//                'entry_type' => ClientType::class,
//                'allow_add' => true,
//                'allow_delete' => true
//            ))
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
