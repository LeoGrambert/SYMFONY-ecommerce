<?php

/**
 * User: leo
 * Date: 25/02/17
 * Time: 18:57
 */

namespace LG\CoreBundle\DateReservation;

use LG\CoreBundle\Entity\Booking;

/**
 * Class DateReservation
 * @package LG\CoreBundle\DateReservation
 */
class DateReservation
{
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
