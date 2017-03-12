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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Class HomeController
 * @package LG\CoreBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" : "fr|en"})
 */
class HomeController extends Controller
{
    /**
     * @return Response
     * @Route("/", name="home.index", methods={"GET"})
     * @throws \Twig_Error
     */
    public function indexAction(){
        return $this->get('templating')->renderResponse('LGCoreBundle:Home:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/", methods={"GET"})
     * @throws \Twig_Error
     */
    public function redirectToHome(){
        return $this->redirectToRoute('home.index');
    }

}
