<?php

namespace Admin\PageBundle\Helpers\Tree\Category;

use Admin\AplicationBundle\Helpers\Tree\TreeAbstract;

class AdminCategoryTree extends TreeAbstract {

    public function createTree( $rows, $parentId = 0 ) {

         return $this->_createTree( $rows );;
    }


    protected function _openChildTag( $child){

        return "<li data-lid=\"".$child->getId()."\">";

    }

    protected function _childHTML( $child ) {

            return    "
                            <div class=\"page\" data-id=\"".$child->getId()."\"> " .$child->getTitle(). "</div>

                      ";

    }




}