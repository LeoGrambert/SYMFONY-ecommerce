<?php

namespace LG\CoreBundle\Entity\EntityListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use LG\CoreBundle\Entity\Booking;

class BookingTokenListener
{
    /**
     * @param Booking $booking
     * @param LifecycleEventArgs $event
     */
    public function postPersist(Booking $booking, LifecycleEventArgs $event)
    {
        $booking->setToken($booking->getId());
        $event->getObjectManager()->persist($booking);
        $event->getObjectManager()->flush();
    }
}