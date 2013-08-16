<?php

namespace Site\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PageController extends Controller
{


    public function pageAction($page, $locale)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PageBundle:Page')->find( $page );
        $entity->setTranslatableLocale( $locale );

        $em->refresh($entity);
        if( $widget = $entity->getWidget()){
            $widget = unserialize($widget);

        }

        return $this->render('FrontBundle:Page:page.html.twig',
            array(
                'page' => $page,
                'entity' => $entity,
            ) );

    }
    


}
