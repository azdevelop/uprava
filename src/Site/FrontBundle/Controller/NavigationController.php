<?php

namespace Site\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\NavMenuBundle\Helpers\Tree\Navigation\TopNavTree;

class NavigationController extends Controller
{

    public function navigationAction( $position, $locale ){
  
        $em = $this->getDoctrine()->getManager();
        
        $nav = $em->getRepository('NavMenuBundle:NavMenu')->findBy( array('position' => $position) );

        $tree = new TopNavTree($this, $locale);
        $navTree =  $tree->createTree( $nav );

        return $this->render('FrontBundle:Navigation:navigation.html.twig',
                                array(
                                    'navTree' => $navTree                               
                                )
        );
    }

}
