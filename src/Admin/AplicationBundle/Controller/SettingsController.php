<?php

namespace Admin\AplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Admin\AplicationBundle\Entity\Settings;
use Admin\AplicationBundle\Form\AppSettingsType;

class SettingsController extends Controller
{
    public function settingsAction( Request $request )
    {
        $entity = new Settings();
        $form = $this->createForm(new AppSettingsType(), $entity);
        $formData = $request->get('form');
        $request->request->set('admin_aplicationbundle_appsettingstype',$formData);
        $form->submit($request);

        $em = $this->getDoctrine()->getManager();
        $settings = $em->getRepository('AplicationBundle:Settings')->findOneByName( $formData['name'] );

        if (!$settings) {
            $em->persist($entity);
            $em->flush();
        }
        else{
            $settings->setValue( $formData['value'] );
            $em->flush();
        }


        return $this->redirect($this->generateUrl('dashboard_homepage'));

    }
}
