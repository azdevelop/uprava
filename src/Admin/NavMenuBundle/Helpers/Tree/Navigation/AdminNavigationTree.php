<?php

namespace Admin\NavMenuBundle\Helpers\Tree\Navigation;

use Admin\NavMenuBundle\Helpers\Tree\TreeAbstract;

class AdminNavigationTree extends TreeAbstract {


    protected $_openParentTag = "<ol class=\"dd-list\">";

    protected $_closeParentTag = "</ol>";


    public function createTree( $rows, $parentId = 0 ) {

        return $this->_createTree( $rows );
    }


    protected function _childHTML( $child ) {

            return    "<li class=\"dd-item dd3-item\"  data-id=\"".$child->getId()."\">

                            <div class=\"dd-handle dd3-handle\">Drag</div><div class=\"dd3-content\">
                                ".$child->getName()." id: " .$child->getId(). "

                            </div>

                      ";

    }




}