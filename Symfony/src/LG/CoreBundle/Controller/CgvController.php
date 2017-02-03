<?php
/**
 * User: leo
 * Date: 03/02/17
 * Time: 18:41
 */

/**
 * Namespace
 */
namespace LG\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class CgvController
 * @package LG\CoreBundle\Controller
 * @Route("/cgv")
 */
class CgvController extends Controller
{
    /**
     * @return Response
     * @Route("", name="cgv.index", methods={"GET"})
     * @throws \Twig_Error
     */
    public function indexAction(){
        return $this->get('templating')->renderResponse('LGCoreBundle:Cgv:index.html.twig');
    }

}