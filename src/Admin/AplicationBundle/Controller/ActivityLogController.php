<?php

namespace Admin\AplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ActivityLogController extends Controller
{
    public function indexAction( $userId )
    {
        $em = $this->getDoctrine()->getManager();

        $logs = $em->getRepository('AplicationBundle:ActivityLog')->getActivityLogs($userId);

        return $this->render('AplicationBundle:ActivityLog:index.html.twig', array('logs' => $logs));
    }
}
