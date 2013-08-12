<?php

namespace Admin\NavMenuBundle\Helpers\Tree\Navigation;

use Admin\AplicationBundle\Helpers\Tree\TreeAbstract;
use Symfony\Component\Routing\Generator\UrlGenerator;
class TopNavTree extends TreeAbstract {


    public function createTree( $rows, $parentId = 0 ) {

        return $this->_createTree( $rows );
    }


    protected function _openChildTag( $child){

        return "<li>";

    }

    protected function _childHTML( $child ) {
       
            $url = $_SERVER['SERVER_NAME'];
            $url .= '/app_dev.php/page/' . $child->getId();
            return    "
                          <a href=\"//".$url."\" class=\"label label-info\">".$child->getName()." </a>

                      ";

    }

}