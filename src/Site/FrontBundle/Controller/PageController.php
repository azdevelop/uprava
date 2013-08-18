<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PageController extends Controller
{


    public function pageAction($page, $locale)
    {
        $em = $this->getDoctrine()->getManager();
        $p = $this->get('request')->query->get('page',1);
        $entity = $em->getRepository('PageBundle:Page')->find( $page );
        $entity->setTranslatableLocale( $locale );

        $em->refresh($entity);
        if( $widget = $entity->getWidget()){
            $widget = unserialize($widget);
           
            $posts = $em->getRepository('ArticleBundle:Post')->findAll( );
            
        }

        return $this->render('FrontBundle:Page:page.html.twig',
            array(
                'page' => $page,
                'entity' => $entity,
                'posts' => $posts
            ) );

    }
    


}
