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
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        $numberTickets = $numberTicketsChild + $numberTicketsNormal + $numberTicketsReduce + $numberTicketsSenior;
        $dateReservation = $booking->getDateReservation();
        $dateReservationToString = $dateReservation->format('d-m-Y');
        $price = ($numberTicketsChild*8) + ($numberTicketsNormal*16) + ($numberTicketsReduce*10) + ($numberTicketsSenior*12);
        
        return $this->get('templating')->renderResponse('LGCoreBundle:Booking:booking_form_step_two.html.twig', [
            "booking" => $booking,
            'numberTicketsNormal' => $numberTicketsNormal,
            'numberTicketsReduce' => $numberTicketsReduce,
            'numberTicketsChild' => $numberTicketsChild,
            'numberTicketsSenior' => $numberTicketsSenior,
            "numberTickets" => $numberTickets,
            "dateReservationToString" => $dateReservationToString,
            "price" => $price]);
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
        $clientsDenormalized = [];

        // step one denormalize
        $clients = json_decode($request->get('data'), true);
        foreach ($clients as $client) {
            $clientsDenormalized[] = $this->get('serializer')->denormalize($client, Client::class);
        }

        $em = $this->getDoctrine()->getManager();


            foreach ($clientsDenormalized as $clientDenormalized){
            // step two persist using booking
                dump($clientDenormalized);
                $clientDenormalized->setBooking($booking);
                $em->persist($clientDenormalized);
                $em->flush();
            }
        return new Response;
    }

    /**
     * @Route("/create/3/{id}", name="booking.create.stepThree", methods={"POST", "GET"}, requirements={"id" : "\d+"})
     * @return Response
     * @ParamConverter("booking", options={"id" = "id"})
     */
    public function bookingCreateStepThree (Booking $booking)
    {
        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsSenior = $booking->getTicketNumberSenior();
        $numberTickets = $numberTicketsChild + $numberTicketsNormal + $numberTicketsReduce + $numberTicketsSenior;
        $dateReservation = $booking->getDateReservation();
        $dateReservationToString = $dateReservation->format('d-m-Y');
        $price = ($numberTicketsChild*8) + ($numberTicketsNormal*16) + ($numberTicketsReduce*10) + ($numberTicketsSenior*12);
        $email = $booking->getEmail();

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

        $em = $this->getDoctrine()->getManager();

        if ($stripe->checkout($booking)){
            $booking->setPaymentIsSuccess(true);
            $em->persist($booking);
            $em->flush();
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
        $dateReservation = $booking->getDateReservation();
        $dateReservationToString = $dateReservation->format("d-m-y");
        $isDaily = $booking->getIsDaily();
        $chain = $booking->getCodeReservation();

        $numberTicketsNormal = $booking->getTicketNumberNormal();
        $numberTicketsReduce = $booking->getTicketNumberReduce();
        $numberTicketsChild = $booking->getTicketNumberChild();
        $numberTicketsSenior = $booking->getTicketNumberSenior();

        $em = $this->getDoctrine()->getRepository('LGCoreBundle:Client');
        
        $bookingID = $booking->getId();

        $clientsName = $em->getClientsNameById($bookingID);
        
        return $this->get('templating')->renderResponse('LGCoreBundle:MailConfirmation:template.html.twig', [
            "dateReservationToString" => $dateReservationToString, 
            "isDaily" => $isDaily, 
            "chain" => $chain,
            "clientsName" => $clientsName,
            "numberTicketsNormal" => $numberTicketsNormal,
            "numberTicketsReduce" => $numberTicketsReduce,
            "numberTicketsSenior" => $numberTicketsSenior,
            "numberTicketsChild" => $numberTicketsChild
        ]);
    }
}