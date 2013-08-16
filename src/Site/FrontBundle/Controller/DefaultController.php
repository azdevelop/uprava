<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\NavMenuBundle\Helpers\Tree\Navigation\TopNavTree;

class DefaultController extends Controller
{
    public function indexAction( $locale )
    {
        
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('ArticleBundle:Post')->findAllByLocale($locale);
        
        return $this->render(
             'FrontBundle:Default:index.html.twig',
             array(
                 'posts' => $posts
                )
                );
    }


    public function pageAction($page, $locale)
    {

        return $this->render('FrontBundle:Default:page.html.twig',
                                array(
                                    'page' => $page
                                )
        );
    }
    
    public function postAction( $post, $locale ){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ArticleBundle:Post')->find( $post );
        $entity->setTranslatableLocale($locale);
        $em->refresh($entity);
        return $this->render('FrontBundle:Default:post.html.twig',
                                array(
                                    'post' => $entity
                                  
                                )
        );
    }
    
    public function navigationAction( $position, $locale ){
  
        $em = $this->getDoctrine()->getManager();
        
        $nav = $em->getRepository('NavMenuBundle:NavMenu')->findBy( array('position' => $position) );

        $tree = new TopNavTree($this, $locale);
        $navTree =  $tree->createTree( $nav );

        return $this->render('FrontBundle:Default:navigation.html.twig',
                                array(
                                    'navTree' => $navTree                               
                                )
        );
    }

}
