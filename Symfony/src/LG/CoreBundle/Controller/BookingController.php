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

/**
 * Class BookingController
 * @package LG\CoreBundle\Controller
 * @Route("/{_locale}/booking")
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
        $id = $booking->getId();
        // Use NumberTickets service to get tickets number and the associated price
        $bookingProvider = $this->get('lg_core_bundle.bookingprovider');
        $numberTickets = $bookingProvider->getNumberTickets($booking);
        $price = $bookingProvider->getPrice($booking);
        //Get tickets number for each price
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        // Get the date reservation (string format)
        $dateReservationToString = $bookingProvider->getDateReservationToString($booking);

        //return the twig template
        return $this->get('templating')->renderResponse('LGCoreBundle:Booking:booking_form_step_two.html.twig', [
            "booking" => $booking,
            'numberTicketsNormal' => $numberTicketsNormal,
            'numberTicketsReduce' => $numberTicketsReduce,
            'numberTicketsChild' => $numberTicketsChild,
            'numberTicketsSenior' => $numberTicketsSenior,
            "numberTickets" => $numberTickets,
            "dateReservationToString" => $dateReservationToString,
            "price" => $price,
            "id" => $id
        ]);
    }

    /**
     * @Route("/client/{id}", name="booking.client.create", methods={"POST", "GET"}, requirements={"id" : "\d+"})
     * @ParamConverter("booking", options={"id" = "id"})
     * @param Request $request
     * @param Booking $booking
     * @return Response
     */
    public function createClientBooking (Request $request, Booking $booking)
    {
        $json = new JsonResponse();
        $validator = $this->get('validator');
        $clientsDenormalized = [];
        // step one denormalize data and push client in an array
        $clients = json_decode($request->get('data'), true);
        dump($clients);

        foreach ($clients as $client) {
            try{
                $clientsDenormalized[] = $this->get('serializer')->denormalize($client, Client::class);
            } catch (\Exception $e) {
                return $json->setStatusCode(500)->setData($this->get("translator")->trans('booking.create.error.type'));
            }
        }
        dump($clientsDenormalized);
        // step two persist using booking
        $em = $this->getDoctrine()->getManager();
        foreach ($clientsDenormalized as $clientDenormalized){
            // calling the validator to use assert contrainst on entity
            $errors = $validator->validate($clientDenormalized);
            if($errors->count() == 0) {
                // if no error, persist
                $clientDenormalized->setBooking($booking);
                $em->persist($clientDenormalized);
                $em->flush();
            } else {
                return $json->setStatusCode(422)->setData($this->get("translator")->trans('booking.create.error.form'));
            }
        }
        return $json->setStatusCode(200)->setData($this->get("translator")->trans('booking.create.success'));
    }

    /**
     * @Route("/create/3/{id}", name="booking.create.stepThree", methods={"POST", "GET"}, requirements={"id" : "\d+"})
     * @return Response
     * @ParamConverter("booking", options={"id" = "id"})
     */
    public function bookingCreateStepThree (Booking $booking)
    {
        //Use NumberTickets service to get the tickets number and the associated price
        $bookingProvider = $this->get('lg_core_bundle.bookingprovider');
        $numberTickets = $bookingProvider->getNumberTickets($booking);
        $price = $bookingProvider->getPrice($booking);
        // Get the date reservation and email adress
        $dateReservationToString = $bookingProvider->getDateReservationToString($booking);
        $email = $booking->getEmail();

        //Return twig template
        return $this->get('templating')->renderResponse('LGCoreBundle:Booking:booking_form_step_three.html.twig', [
            "booking" => $booking,
            "numberTickets" => $numberTickets,
            "dateReservationToString" => $dateReservationToString,
            "price" => $price,
            "email" => $email
        ]);
    }

    /**
     * @Route("/order/{id}", name="order.checkout", methods="POST", requirements={"id" : "\d+"})
     * @ParamConverter("booking", options={"id" = "id"})
     * @param Booking $booking
     * @return Response
     */
    public function checkoutAction(Booking $booking)
    {
        //Using Stripe as a service
        $stripe = $this->get('lg_core_bundle.stripe');
        //Using entity manager
        $em = $this->getDoctrine()->getManager();
        //Using booking provider service
        $bookingProvider = $this->get('lg_core_bundle.bookingprovider');

        if ($stripe->checkout($bookingProvider, $booking)){

            //This booking attribute indicates that the order has been paid
            $booking->setPaymentIsSuccess(true);
            $em->persist($booking);
            $em->flush();

            //We get email adress to use SwiftMailer
            $email = $booking->getEmail();
            $message = \Swift_Message::newInstance()
                ->setSubject('Confirmation de votre commande')
                ->setFrom(['devTestLG@gmail.com' => 'Musée du Louvre'])
                ->setTo($email)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->bookingMailConfirmation($booking));
            $this->get('mailer')->send($message);

            return $this->redirectToRoute("booking.create.stepFour", ['id' => $booking->getId()]);
        } else {
            return $this->redirectToRoute("booking.create.stepThree", ['id' => $booking->getId()]);
        }
    }

    /**
     * @Route("/create/4/{id}", name="booking.create.stepFour", methods={"POST", "GET"}, requirements={"id" : "\d+"})
     * @return Response
     * @ParamConverter("booking", options={"id" = "id"})
     * @return Response
     */
    public function bookingCreateStepFour (Booking $booking)
    {
        $codeReservation = $booking->getCodeReservation();
        $emailReservation = $booking->getEmail();

        return $this->get('templating')->renderResponse('LGCoreBundle:Booking:booking_form_step_four.html.twig', [
            "booking" => $booking, 
            "codeReservation" =>$codeReservation, 
            "emailReservation" => $emailReservation
        ]);
    }

    /**
     * @Route("/mailConfirmation/{id}", name="booking.mailConfirmation", methods={"POST", "GET"}, requirements={"id" : "\d+"})
     * @return Response
     * @ParamConverter("booking", options={"id" = "id"})
     * @return Response
     */
    public function bookingMailConfirmation (Booking $booking)
    {
        $bookingProvider = $this->get('lg_core_bundle.bookingprovider');
        $em = $this->getDoctrine()->getRepository('LGCoreBundle:Client');
        
        // Get informations to construct mailing
        $dateReservationToString = $bookingProvider->getDateReservationToString($booking);
        $isDaily = $booking->getIsDaily();
        $chain = $booking->getCodeReservation();
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsSenior = $booking->getTicketNumberSenior();

        //Use Client repository to get last names and first names
        $bookingID = $booking->getId();
        $clientsName = $em->getClientsNameById($bookingID);

        //Return the mail template
        return $this->get('templating')->renderResponse('LGCoreBundle:MailConfirmation:template.html.twig', [
            "dateReservationToString" => $dateReservationToString, 
            "isDaily" => $isDaily, 
            "chain" => $chain,
            "clientsName" => $clientsName,
            "numberTicketsNormal" => $numberTicketsNormal,
            "numberTicketsReduce" => $numberTicketsReduce,
            "numberTicketsSenior" => $numberTicketsSenior,
            "numberTicketsChild" => $numberTicketsChild
        ])
            ->getContent();
    }
}
