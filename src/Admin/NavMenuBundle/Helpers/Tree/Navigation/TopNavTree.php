<?php

namespace Admin\NavMenuBundle\Helpers\Tree\Navigation;
use Admin\AplicationBundle\Helpers\Tree\TreeAbstract;

class TopNavTree extends TreeAbstract {

    protected $_controller;
    protected $_locale;
    public function __construct( $navcontroller, $locale) {
        $this->_controller = $navcontroller;
        $this->_locale = $locale;
    }
    
    public function createTree( $rows, $parentId = 0 ) {

        return $this->_createTree( $rows );
    }


    protected function _openChildTag( $child){

        return "<li>";

    }

    protected function _childHTML( $child ) {
      
            $em = $this->_controller->getDoctrine()->getManager();

            if( $child->getType() == 'page' && $child->getPageId() ) {
                $page = $em->getRepository('PageBundle:Page')->find( $child->getPageId() );

                $url = $this->_controller->generateURL('front_page', array('page' => $page->getName(), 'locale'=>$this->_locale));
            }
            else {
                $url = $child->getUrl();
            }

            return    "
                          <a href=\"".$url."\" class=\"label label-info\">".$child->getTitle()." </a>

                      ";

    }

}