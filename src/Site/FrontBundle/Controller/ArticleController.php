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

}
