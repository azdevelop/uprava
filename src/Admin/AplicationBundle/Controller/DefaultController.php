<?php

namespace Admin\AplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AplicationBundle:Default:index.html.twig', array('name' => $name));
    }
}
