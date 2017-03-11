<?php

/**
 * User: leo
 * Date: 25/02/17
 * Time: 18:32
 */

namespace LG\CoreBundle\Provider;

use Doctrine\ORM\EntityManagerInterface;
use LG\CoreBundle\Entity\Booking;

/**
 * Class BookingProvider. It's a service that allows you to do many things on Booking.
 * @package LG\CoreBundle\NumberTickets
 */
class BookingProvider
{
    private $em;

    /**
     * LimitTicketsValidator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Get the tickets number, all prices
     * @param Booking $booking
     * @return int
     */
    public function getNumberTickets(Booking $booking){
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        $numberTickets = $numberTicketsChild + $numberTicketsNormal + $numberTicketsReduce + $numberTicketsSenior;
        
        return $numberTickets;
    }

    /**
     * Get tickets price
     * @param Booking $booking
     * @return int
     */
    public function getPrice(Booking $booking){
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        $price = ($numberTicketsChild*8) + ($numberTicketsNormal*16) + ($numberTicketsReduce*10) + ($numberTicketsSenior*12);

        return $price;
    }

    /**
     * Get the date reservation and convert to string
     * @param Booking $booking
     * @return string
     */
    public function getDateReservationToString(Booking $booking){
        $dateReservation = $booking->getDateReservation();
        $dateReservationToString = $dateReservation->format("d-m-Y");

        return $dateReservationToString;
    }

    /**
     * This function allow you to check the number of tickets remaining for sale
     * With a query builder, I get all Booking database (after current date, it's useless to get past dates).
     * For each tickets (normal, reduce, child or senior), I add a dateReservation in an array datesReservation.
     * I count the duplicates dates in array. If a date is present more than 1000 times, function return false.
     * @param Booking $booking
     * @return bool
     */
    public function oneThousandTickets(Booking $booking)
    {
        $isAvailable = false;
        $datesReservation = [];
        $dateValue = $this->getDateReservationToString($booking);

        //Call findByDateReservation in repository/BookingRepository.php
        $bookingsRepo = $this->em->getRepository('LGCoreBundle:Booking')->findByDateReservation();

        //For each result, we get booking date and tickets number
        foreach ($bookingsRepo as $bookingRepo) {
            $dateReservation = $bookingRepo->getDateReservation()->format('d-m-Y');
            $numberTicketsNormal = $bookingRepo->getTicketNumberNormal();
            $numberTicketsReduce = $bookingRepo->getTicketNumberReduce();
            $numberTicketsChild = $bookingRepo->getTicketNumberChild();
            $numberTicketsSenior = $bookingRepo->getTicketNumberSenior();
            $numberTickets = $numberTicketsChild + $numberTicketsSenior + $numberTicketsNormal + $numberTicketsReduce;

            //I add as many dates in array as there are tickets for the day
            for($i=0;$i<$numberTickets;$i++){
                $datesReservation[] = $dateReservation ;
            }
        }

        //I also add user choice as many as there are tickets
        for($i=0;$i<$this->getNumberTickets($booking);$i++){
            $datesReservation[] = $dateValue;
        }

        //For each date, I count number of times it's present in array
        $dates = array_count_values($datesReservation);
        
        //If a date is present 1000 times or more, $isAvailable is false
        foreach ($dates as $date => $number) {
            if (($number >= 1000) && ($dateValue == $date)) {
                $isAvailable = false;
                return $isAvailable;
            } else {
                $isAvailable = true;
            }
        }

        //Return a boolean. I use this in controller to allow (or not) the Booking persist on Step One
        //I also use this on Step Three to check before payment
        return $isAvailable;
    }
}
