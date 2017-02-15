<?php

namespace LG\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookingType extends AbstractType
{

    /**
     * @return string
     * The function recovers all days off for the current year and the next.
     * Then, the function assemble these dates in a string.
     * The string is used to disable dates in build form function.
     */
    private function getDisabledDate()
    {
        $disabledDateCurrentYear = '';
        $disabledDateNextYear = '';
        $currentYear = date('Y');
        $nextYear = date('Y')+1;
        $daysOff = ['01-01-', '17-04-', '01-05-', '08-05-', '25-05-', '05-06-', '14-07-', '15-08-', '01-11-', '11-11-'];
        foreach ($daysOff as $dayOff){
            $disabledDateCurrentYear = $disabledDateCurrentYear.$dayOff.$currentYear.', ';
            $disabledDateNextYear = $disabledDateNextYear.$dayOff.$nextYear.', ';
        }
        $disabledDate = $disabledDateCurrentYear.'25-12-'.$currentYear.', '.$disabledDateNextYear.'25-12-'.$nextYear;
        return $disabledDate;
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
            ->add('email', EmailType::class, [
                'label' => 'Entrez votre adresse e-mail'
            ])
            ->add('ticketNumberNormal', TextType::class, array(
                'label' => 'Tarif Normal',
            ))
            ->add('ticketNumberReduce', TextType::class, array(
                'label' => 'Tarif Réduit',
            ))
            ->add('ticketNumberChild', TextType::class, array(
                'label' => 'Tarif Enfant',
            ))
            ->add('ticketNumberSenior', TextType::class, array(
                'label' => 'Tarif Senior',
            ))
            ->add('stepThree', SubmitType::class, [
                'label' => 'Ajouter au panier'
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
