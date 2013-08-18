<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SearchController extends Controller
{


    public function resultsAction( )
    {
        $q = $this->get('request')->query->get('q',null);
        $p = $this->get('request')->query->get('page',1);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('ArticleBundle:Post')->searchPostsBy($q);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $entities,
        $p,
        5/*limit per page*/
        );
      
        return $this->render('FrontBundle:Search:results.html.twig',
            array(
                'results' => $q,
                'posts' => $pagination
                
            ) );

    }
    


}
