<?php
/**
 * User: leo
 * Date: 15/02/17
 * Time: 12:58
 */

namespace LG\CoreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\ConstraintValidator;

class LimitTicketsValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        $datesReservation = [];
        $dateValue = $value->format('d-m-Y');

        $bookings = $this->em->getRepository('LGCoreBundle:Booking')->findByDateReservation();

        foreach ($bookings as $booking) {
            $dateReservation = $booking->getDateReservation()->format('d-m-Y');
            $datesReservation[] = $dateReservation;
        }
        $dates = array_count_values($datesReservation);
        foreach ($dates as $date => $number) {
            if (($number >= 1000) && ($dateValue == $date)) {
                $this->context->addViolation($constraint->message);
            }
        }
    }
}