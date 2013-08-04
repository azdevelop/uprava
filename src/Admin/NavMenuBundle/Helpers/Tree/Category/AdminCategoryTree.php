<?php

namespace Admin\NavMenuBundle\Helpers\Tree\Category;

use Admin\NavMenuBundle\Helpers\Tree\TreeAbstract;

class AdminCategoryTree extends TreeAbstract {


    public function createTree( $rows, $parentId = 0 ) {

        return $this->_createTree( $rows );
    }


    protected function _childHTML( $child ) {

            return    "<li>

                            <div>
                              asdads

                            </div>

                      ";

    }




}