<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CategoryController extends Controller
{


    public function indexAction( $category, $locale )
    {
        $p = $this->get('request')->query->get('page',1);
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('CategoryBundle:Category')->findOneBy(array('name' => $category));
        $category->setTranslatableLocale($locale);
        $em->refresh($category);
        $posts = $em->getRepository('ArticleBundle:Post')->findAllByLocale( $locale, $category->getId() );
    
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $p,
            5/*limit per page*/
        );
        return $this->render('FrontBundle:Category:index.html.twig',
            array(
                'posts' => $pagination,
                'category' => $category
            )
        );
    }
    
     

}
