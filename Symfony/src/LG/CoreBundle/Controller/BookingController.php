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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class BookingController
 * @package LG\CoreBundle\Controller
 * @Route("/booking")
 */
class BookingController extends Controller
{
    /**
     * @Route("", name="booking.index", methods={"GET"})
     * @return Response
     * @throws \Twig_Error
     */
    public function indexAction()
    {
//        return $this->get('templating')->renderResponse('LGCoreBundle:Booking:booking.html.twig');

    }

    /**
     * @Route("/create/1", name="booking.create.stepOne", methods={"POST", "GET"})
     * @param Request $request
     * @return Response
     * @throws \Twig_Error
     */
    public function bookingCreateStepOne(Request $request)
    {
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking, ['action' => $this->get('router')->generate('booking.create.stepOne')]);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($booking);
                $em->flush();
                return $this->redirectToRoute("booking.create.stepTwo");
            }
        }

        return $this->get('templating')->renderResponse('@LGCore/Booking/booking_form_step_one.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/create/2/{id}", name="booking.create.stepTwo", methods={"POST", "GET"}, requirements={"id" : "\d+"})
     * @return Response
     * @ParamConverter("booking", options={"id" = "id"})
     * @return Response
     */
    public function bookingCreateStepTwo (Booking $booking)
    {
        return $this->get('templating')->renderResponse('LGCoreBundle:Booking:booking_form_step_two.html.twig', ["booking" => $booking]);
    }

    /**
     * @Route("/client/{id}", name="booking.client.create", methods={"POST", "GET"}, requirements={"id" : "\d+"})
     * @ParamConverter("booking", options={"id" = "id"})
     * @param Request $request
     * @param Booking $booking
     */
    public function createClientBooking (Request $request, Booking $booking)
    {
        // testing by the routes :

        // will get data from ajax call
        $clients = $request->get('data');
        dump($clients);

        foreach ($clients as $client) {
            // persist inside client and booking
        }
        // todo read symfony normalizer and denormalizer...we will need it right here

    }
}