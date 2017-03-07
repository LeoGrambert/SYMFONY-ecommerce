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
    public function testToken(){
        $booking = new Booking();
        $booking->setToken(24);
        $this->assertNotNull($booking->getToken());
    }

    public function testClient(){
        $booking = new Booking();
        $client = new Client();
        $this->assertEquals($booking->getId(), $client->getBooking());
    }
}