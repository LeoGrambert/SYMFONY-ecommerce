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
use Doctrine\ORM\Query\Expr\Select;
use LG\CoreBundle\Entity\Booking;
use LG\CoreBundle\Entity\Client;
use LG\CoreBundle\Form\BookingType;
use LG\CoreBundle\LGCoreBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    public function bookingAction(Request $request){
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($booking);
                $em->flush();
                return $this->redirectToRoute('lg_core_homepage');
            }
        }

        $content = $this->get('templating')->render('LGCoreBundle:Booking:booking.html.twig', ['form' => $form->createView()]);
        return new Response($content);
    }
}