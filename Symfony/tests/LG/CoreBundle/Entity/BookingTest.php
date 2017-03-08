<?php

/**
 * User: leo
 * Date: 07/03/17
 * Time: 18:33
 */

namespace tests\LG\CoreBundle\Entity;

use LG\CoreBundle\Entity\Booking;
use LG\CoreBundle\Entity\Client;
use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    /**
     * Test token attribute from Booking entity
     */
    public function testToken(){
        $booking = new Booking();
        $booking->setToken(24);
        $this->assertNotNull($booking->getToken());
    }

    /**
     * Test client attribute from Booking entity
     */
    public function testClient(){
        $booking = new Booking();
        $client = new Client();
        $this->assertEquals($booking->getId(), $client->getBooking());
    }

    /**
     * Test generateCodeReservation() from Booking entity
     */
    public function testGenerateCodeReservation(){
        $booking = new Booking();
        $this->assertNotNull($booking->getCodeReservation());
    }

    /**
     * Test random() from Booking entity
     */
    public function testRandom(){
        $booking = new Booking();
        $this->assertNotNull($booking->random(3));
    }
}