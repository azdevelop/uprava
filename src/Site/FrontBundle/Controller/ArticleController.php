<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ArticleController extends Controller
{


    public function postAction($post, $locale)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ArticleBundle:Post')->find( $post );
        $entity->setTranslatableLocale($locale);
        $em->refresh($entity);
        return $this->render('FrontBundle:Article:post.html.twig',
            array(
                'post' => $entity
            )
        );
    }
    
     public function listAction( $locale )
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('ArticleBundle:Post')->findAllByLocale($locale);
        
        return $this->render(
             'FrontBundle:Article:list.html.twig',
             array(
                 'posts' => $posts
                )
        );
    }

}
