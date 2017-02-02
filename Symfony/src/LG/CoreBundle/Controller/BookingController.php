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

use LG\CoreBundle\Entity\Booking;
use LG\CoreBundle\Entity\Client;
use LG\CoreBundle\Form\BookingType;
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
     * @throws \Twig_Error
     */
    public function indexAction(){
        $content = $this->get('templating')->render('LGCoreBundle:Booking:index.html.twig');
        return new Response($content);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Twig_Error
     */
    public function bookingAction(Request $request){
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($booking->getClients());
                $em->persist($booking);
                $em->flush();
            }
        }

        $content = $this->get('templating')->render('LGCoreBundle:Booking:booking.html.twig', ['form' => $form->createView()]);
        return new Response($content);
    }
}