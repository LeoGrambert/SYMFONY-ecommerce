<?php
/**
 * User: leo
 * Date: 16/01/17
 * Time: 19:41
 */

/**
 * Namespace
 */
namespace LG\CoreBundle\Controller;

/**
 * Use
 */
use LG\CoreBundle\Entity\Booking;
use LG\CoreBundle\Entity\Client;
use LG\CoreBundle\LGCoreBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



/**
 * Class BookingController
 * @package LG\CoreBundle\Controller
 */
class BookingController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction(Request $request){

        $content = $this->get('templating')->render('LGCoreBundle:Booking:index.html.twig');

        return new Response($content);
    }

    public function bookingAction(){
        $booking = new Booking();
        $booking->setDateReservation(new \DateTime());
        $booking->setDateAchat(new \DateTime());
        $booking->setIsDaily(true);
        $booking->setTicketNumber(2);
        $booking->setEmail('leogrambert@gmail.com');

        $em = $this->getDoctrine()->getManager();

        $em->persist($booking);

        $em->flush();
        
        $repository = $this->getDoctrine()->getManager()->getRepository('LGCoreBundle:Booking');
        $listBookings = $repository->findAll();

        $content = $this->get('templating')->render('LGCoreBundle:Booking:booking.html.twig', ['listBookings' => $listBookings]);
        return new Response($content);
    }
}