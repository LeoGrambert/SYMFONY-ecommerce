<?php

/**
 * User: leo
 * Date: 25/02/17
 * Time: 18:32
 */

namespace LG\CoreBundle\NumberTickets;

use LG\CoreBundle\Entity\Booking;

/**
 * Class NumberTickets. It's a service that allows you to get tickets number and price which is associated.
 * @package LG\CoreBundle\NumberTickets
 */
class NumberTickets
{
    /**
     * Get the tickets number with normal price
     * @param Booking $booking
     * @return int
     */
    public function getNumberTicketsNormal(Booking $booking){
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        return $numberTicketsNormal;
    }

    /**
     * Get the tickets number with reduce price
     * @param Booking $booking
     * @return int
     */
    public function getNumberTicketsReduce(Booking $booking){
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        return $numberTicketsReduce;
    }

    /**
     * Get the tickets number with child price
     * @param Booking $booking
     * @return int
     */
    public function getNumberTicketsChild(Booking $booking){
        $numberTicketsChild = $booking->getTicketNumberChild();
        return $numberTicketsChild;
    }

    /**
     * Get the tickets number with senior price
     * @param Booking $booking
     * @return int
     */
    public function getNumberTicketsSenior(Booking $booking){
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        return $numberTicketsSenior;
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
}