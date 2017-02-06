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
use Symfony\Component\HttpFoundation\RedirectResponse;
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
                return $this->redirectToRoute("booking.create.stepTwo", ['id' => $booking->getId()]);
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
     * @return RedirectResponse
     */
    public function createClientBooking (Request $request, Booking $booking)
    {
        $clientsDenormalized = [];
        // This code below is a boostrap to guide you through persistance

        // step one denormalize
        $clients = json_decode($request->get('data'), true);
        foreach ($clients as $client) {
            $clientsDenormalized[] = $this->get('serializer')->denormalize($client, Client::class);
            dump($clientsDenormalized);
        }

        $em = $this->getDoctrine()->getManager();

        foreach ($clientsDenormalized as $clientDenormalized){
            dump($clientDenormalized);
            // step two persist using booking
            $clientDenormalized->setBooking($booking);
            $em->persist($clientDenormalized);
            $em->flush();

            // step three normalize
            $clientNormalized = $this->get("serializer")->normalize($clientDenormalized);

            // last step return json response
            if($clientNormalized) {
                return new JsonResponse($clientNormalized, 200);
             }
        }

        return $this->redirectToRoute("booking.create.stepThree", ['id' => $booking->getId()]);
    }

    /**
     * @Route("/create/3/{id}", name="booking.create.stepThree", methods={"POST", "GET"}, requirements={"id" : "\d+"})
     * @return Response
     * @ParamConverter("booking", options={"id" = "id"})
     * @return Response
     */
    public function bookingCreateStepThree (Booking $booking)
    {
        return $this->get('templating')->renderResponse('LGCoreBundle:Booking:booking_form_step_three.html.twig', ["booking" => $booking]);
    }
}