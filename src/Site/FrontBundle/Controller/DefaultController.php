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


    public function pageAction($page, $locale) {

        return $this->render('FrontBundle:Default:page.html.twig',
                                array(
                                    'page' => $page
                                )
        );
    }
    
    public function postAction( $post, $locale ){

        return $this->render('FrontBundle:Default:post.html.twig',
                                array(
                                    'post' => $post
                                  
                                )
        );
    }


}
