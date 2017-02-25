<?php

/**
 * User: leo
 * Date: 21/02/17
 * Time: 15:04
 */

namespace LG\CoreBundle\Stripe;

use LG\CoreBundle\Entity\Booking;
use LG\CoreBundle\NumberTickets\NumberTickets;

/**
 * Class Stripe
 * @package LG\CoreBundle\Stripe
 * This class is a service using Stripe for payment
 */
class Stripe
{
    public function checkout(NumberTickets $numberTickets, Booking $booking)
    {
        $price = ($numberTickets->getPrice($booking))*100;

        \Stripe\Stripe::setApiKey("sk_test_BmOFQTlYFGqZ6itjVnGiBtrK");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $price, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - Musée du Louvre"
            ));
                $result = true;
                return $result;
            } catch(\Stripe\Error\Card $e) {
                $result = false;
                return $result;
                // The card has been declined
            }
        }

}
