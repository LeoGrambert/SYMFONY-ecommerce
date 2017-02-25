<?php

/**
 * User: leo
 * Date: 25/02/17
 * Time: 19:05
 */

namespace LG\CoreBundle\Email;

use LG\CoreBundle\Entity\Booking;

/**
 * Class Email
 * @package LG\CoreBundle\Email
 */
class Email
{
    /**
     * Get the mail adress
     * @param Booking $booking
     * @return string
     */
    public function getEmail(Booking $booking){
        $email = $booking->getEmail();
        return $email;
    }
}
