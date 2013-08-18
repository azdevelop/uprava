<?php

namespace Admin\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function dashboardAction()
    {
        $siteNameForm = $this->_createForm( 'site_name' );

        $homePageForm = $this->_createForm( 'home_page' );


        return $this->render('DashboardBundle:Default:index.html.twig', array(
                                    'siteNameForm' => $siteNameForm->createView(),
                                    'homePageForm' =>   $homePageForm->createView()
        ));
    }

    private function _createForm( $settingName )
    {
        return $this->createFormBuilder(array('name' => $settingName))
            ->add('value')
            ->add('name', 'hidden')
            ->getForm();
    }

}
