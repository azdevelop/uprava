<?php

namespace Admin\NavMenuBundle\Helpers\Tree\Navigation;

use Admin\AplicationBundle\Helpers\Tree\TreeAbstract;

class AdminNavigationTree extends TreeAbstract {


    protected $_openParentTag = "<ol class=\"dd-list\">";

    protected $_closeParentTag = "</ol>";


    public function createTree( $rows, $parentId = 0 ) {

        return $this->_createTree( $rows );
    }


    protected function _openChildTag( $child){

        return "<li class=\"dd-item dd3-item\"  data-id=\"".$child->getId()."\">";

    }

    protected function _childHTML( $child ) {

            return    "

                            <div class=\"dd-handle dd3-handle\">Drag</div><div class=\"dd3-content\">
                                ".$child->getName()."  <a href=\"".$child->getId()."/edit\" class=\"label label-info\">edit</a>

                            </div>

                      ";

    }




}