<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\NavMenuBundle\Helpers\Tree\Navigation\TopNavTree;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('ArticleBundle:Post')->findAll();
        return $this->render(
             'FrontBundle:Default:index.html.twig',
             array(
                 'posts' => $posts
                )
                );
    }


    public function pageAction($page, $locale)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find( $page );
        $entity->setTranslatableLocale($locale);
       
        $em->refresh($entity);
        if( $widget = $entity->getWidget()){
            $widget = unserialize($widget);
        
        }
        
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
    
    public function navigationAction( $name ){
        
        $em = $this->getDoctrine()->getManager();
        
        $nav = $em->getRepository('NavMenuBundle:NavMenu')->findAll();

        $tree = new TopNavTree();
        $navTree =  $tree->createTree( $nav );

        return $this->render('FrontBundle:Default:navigation.html.twig',
                                array(
                                    'navTree' => $navTree                               
                                )
        );
    }

}
