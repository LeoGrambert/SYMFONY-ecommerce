<?php

/**
 * User: leo
 * Date: 08/03/17
 * Time: 02:32
 */
namespace tests\LG\CoreBundle\Provider;

use LG\CoreBundle\Entity\Booking;
use PHPUnit\Framework\TestCase;

class BookingProviderTest extends TestCase
{
    /**
     * Test getNumberTickets() from Booking Provider
     */
    public function testGetNumberTickets(){
        $booking = new Booking;
        $booking->setTicketNumberNormal(20);
        $ticketNumberNormal = $booking->getTicketNumberNormal();
        $booking->setTicketNumberReduce(20);
        $ticketNumberReduce = $booking->getTicketNumberReduce();
        $booking->setTicketNumberChild(20);
        $ticketNumberChild = $booking->getTicketNumberChild();
        $booking->setTicketNumberSenior(20);
        $ticketNumberSenior = $booking->getTicketNumberSenior();
        $numberTickets = $ticketNumberNormal+$ticketNumberReduce+$ticketNumberChild+$ticketNumberSenior;

        $this->assertEquals(80, $numberTickets);
    }

    /**
     * Test getPrice() from Booking Provider
     */
    public function testGetPrice(){
        $booking = new Booking;
        $booking->setTicketNumberNormal(2);
        $ticketNumberNormal = $booking->getTicketNumberNormal();
        $booking->setTicketNumberReduce(3);
        $ticketNumberReduce = $booking->getTicketNumberReduce();
        $booking->setTicketNumberChild(1);
        $ticketNumberChild = $booking->getTicketNumberChild();
        $booking->setTicketNumberSenior(10);
        $ticketNumberSenior = $booking->getTicketNumberSenior();
        $result = ($ticketNumberNormal*16)+($ticketNumberReduce*10)+($ticketNumberChild*8)+($ticketNumberSenior*12);
        
        $this->assertEquals(190, $result);
    }

    /**
     * Test dateReservationToString() from Booking Provider
     */
    public function testDateReservationToString(){
        $booking = new Booking();
        $booking->setDateReservation(new \DateTime());
        $this->assertRegExp('/^(\d{1,2})-(\d{1,2})-(\d{4})$/',$booking->getDateReservation()->format('d-m-Y'));
    }
}