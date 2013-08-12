<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\NavMenuBundle\Helpers\Tree\Navigation\TopNavTree;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FrontBundle:Default:index.html.twig', array('name' => $name));
    }


    public function pageAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find( $page );

        $topNavigation = $em->getRepository('NavMenuBundle:NavMenu')->findAll();

        $tree = new TopNavTree();
        $topNavigationTree =  $tree->createTree( $topNavigation );

        return $this->render('FrontBundle:Default:page.html.twig',
                                array(
                                    'page' => $page,
                                    'entity' => $entity,
                                    'topNavigationTree' => $topNavigationTree
                                )
        );
    }

}
