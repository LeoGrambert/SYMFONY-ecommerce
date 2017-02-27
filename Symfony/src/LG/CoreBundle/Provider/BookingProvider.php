<?php

/**
 * User: leo
 * Date: 25/02/17
 * Time: 18:32
 */

namespace LG\CoreBundle\Provider;

use LG\CoreBundle\Entity\Booking;

/**
 * Class NumberTickets. It's a service that allows you to get tickets number and price which is associated.
 * @package LG\CoreBundle\NumberTickets
 */
class BookingProvider
{

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
        $dateReservationToString = $dateReservation->format("d-m-y");

        return $dateReservationToString;
    }
}