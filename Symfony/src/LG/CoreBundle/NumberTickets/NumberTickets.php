<?php

/**
 * User: leo
 * Date: 25/02/17
 * Time: 18:32
 */

namespace LG\CoreBundle\NumberTickets;

use LG\CoreBundle\Entity\Booking;

class NumberTickets
{
    public function getNumberTicketsNormal(Booking $booking){
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        return $numberTicketsNormal;
    }

    public function getNumberTicketsReduce(Booking $booking){
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        return $numberTicketsReduce;
    }

    public function getNumberTicketsChild(Booking $booking){
        $numberTicketsChild = $booking->getTicketNumberChild();
        return $numberTicketsChild;
    }

    public function getNumberTicketsSenior(Booking $booking){
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        return $numberTicketsSenior;
    }
    
    public function getNumberTickets(Booking $booking){
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        $numberTickets = $numberTicketsChild + $numberTicketsNormal + $numberTicketsReduce + $numberTicketsSenior;
        
        return $numberTickets;
    }
    
    public function getPrice(Booking $booking){
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        $price = ($numberTicketsChild*8) + ($numberTicketsNormal*16) + ($numberTicketsReduce*10) + ($numberTicketsSenior*12);

        return $price;
    }
}