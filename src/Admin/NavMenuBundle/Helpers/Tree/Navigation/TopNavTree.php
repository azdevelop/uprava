<?php

namespace Admin\NavMenuBundle\Helpers\Tree\Navigation;

use Admin\AplicationBundle\Helpers\Tree\TreeAbstract;

class TopNavTree extends TreeAbstract {


    public function createTree( $rows, $parentId = 0 ) {

        return $this->_createTree( $rows );
    }


    protected function _openChildTag( $child){

        return "<li>";

    }

    protected function _childHTML( $child ) {

            return    "
                          <a href=\"page/".$child->getId()."\" class=\"label label-info\">".$child->getName()." </a>

                      ";

    }

}