<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SearchController extends Controller
{


    public function resultsAction( )
    {
        $q = $this->get('request')->query->get('q',null);
        $em = $this->getDoctrine()->getManager();
       $entities = $em->getRepository('ArticleBundle:Post')->searchPostsBy($q);
        return $this->render('FrontBundle:Search:results.html.twig',
            array(
                'results' => $q,
                'posts' => $entities
                
            ) );

    }
    


}
