<?php

namespace LG\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LGCoreBundle:Default:index.html.twig');
    }
}
