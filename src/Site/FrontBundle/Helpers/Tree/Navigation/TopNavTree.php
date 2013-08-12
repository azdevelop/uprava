<?php

namespace Front\FrontBundle\Helpers\Tree\Navigation;

use Admin\AplicationBundle\Helpers\Tree\TreeAbstract;

class TopNavTree extends TreeAbstract {


    public function createTree( $rows, $parentId = 0 ) {

        return $this->_createTree( $rows );
    }


    protected function _openChildTag( $child){

        return "<li class=\"dd-item dd3-item\"  data-id=\"".$child->getId()."\">";

    }

    protected function _childHTML( $child ) {

            return    "

                            <div >
                                ".$child->getName()."  <a href=\"".$child->getId()."/edit\" class=\"label label-info\">edit</a>

                            </div>

                      ";

    }

}