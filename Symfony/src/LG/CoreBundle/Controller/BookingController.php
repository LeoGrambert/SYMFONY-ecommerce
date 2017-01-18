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
        $content = $this->get('templating')->render('LGCoreBundle:Booking:booking.html.twig');
        return new Response($content);
    }

    public function confirmationAction(){
        return new Response("Ici se trouvera la page de confirmation de la commande");
    }
}