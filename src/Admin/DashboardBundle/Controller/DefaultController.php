<?php

namespace Admin\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    private $_siteName = '';

    private $_homePage = '';


    public function dashboardAction()
    {
        $this->_setSetings();

        $siteNameForm = $this->_createForm( 'site_name', 'text', $this->_siteName );

        $homePageForm = $this->_createForm( 'home_page', 'hidden', $this->_homePage  );


        return $this->render('DashboardBundle:Default:index.html.twig', array(
                                    'siteNameForm' => $siteNameForm->createView(),
                                    'homePageForm' =>   $homePageForm->createView()
        ));
    }

    private function _createForm( $settingName, $type, $value = null)
    {
        return $this->createFormBuilder(array('name' => $settingName))
            ->add('value', $type, array( 'data' => $value ) )
            ->add('name', 'hidden')
            ->getForm();
    }


    private function _setSetings() {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AplicationBundle:Settings')->findAll( );

        if( $entities ) {
            foreach($entities as $e){

                if( $e->getName() == 'home_page'){
                    $this->_homePage =  $e->getValue();
                }

                if( $e->getName() == 'site_name'){
                    $this->_siteName =  $e->getValue();
                }
            }
        }

        return $this;

    }
}
