<?php
/**
 * User: leo
 * Date: 15/02/17
 * Time: 12:58
 */

namespace LG\CoreBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LimitTicketsValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * This function add an constraint on date_reservation field.
     * With a query builder, I get all Booking database (after current date, it's useless to get past dates).
     * For each tickets (normal, reduce, child or senior), I add a dateReservation in an array datesReservation.
     * I count the duplicates dates in array. If a date is present more than 1000 times, the constraint displays the error message and the persist fails.
     *
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $datesReservation = [];
        $dateValue = $value->format('d-m-Y');

        /*
         * I call findByDateReservation in repository/BookingRepository.php
         */
        $bookings = $this->em->getRepository('LGCoreBundle:Booking')->findByDateReservation();

        foreach ($bookings as $booking) {
            $dateReservation = $booking->getDateReservation()->format('d-m-Y');
            $numberTicketsNormal = $booking->getTicketNumberNormal();
            $numberTicketsReduce = $booking->getTicketNumberReduce();
            $numberTicketsChild = $booking->getTicketNumberChild();
            $numberTicketsSenior = $booking->getTicketNumberSenior();
            $numberTickets = $numberTicketsChild + $numberTicketsSenior + $numberTicketsNormal + $numberTicketsReduce;
            /*
             * I add as many dates in array as there are tickets for the day
             */
            for($i=0;$i<$numberTickets;$i++){
                $datesReservation[] = $dateReservation ;
            }
        }
        
        $dates = array_count_values($datesReservation);
        
        foreach ($dates as $date => $number) {
            if (($number >= 1000) && ($dateValue == $date)) {
                $this->context->addViolation($constraint->message);
            }
        }
        
    }
}