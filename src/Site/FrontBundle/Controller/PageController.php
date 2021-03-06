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
        $entity = $em->getRepository('PageBundle:Page')->findOneBy(array('name' => $page));


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event page.');
        }


        $entity->setTranslatableLocale( $locale );
        $posts = null;
        $em->refresh($entity);

        if( $entity->getPageType() == 'combo' && $widget = $entity->getWidget()){
            $widget = unserialize($widget);
           // var_dump($widget); die();
            $posts = $em->getRepository('ArticleBundle:Post')
                    ->findAllByLocale( $locale,$widget['cat'],$widget['posts'], $widget['orderby'] );
            
        }

        return $this->render('FrontBundle:Page:page.html.twig',
            array(
                'page' => $page,
                'entity' => $entity,
                'posts' => $posts
            ) );

    }
    


}
