<?php

namespace Admin\NavMenuBundle\Helpers\Tree\Navigation;

use Admin\AplicationBundle\Helpers\Tree\TreeAbstract;


class AdminNavigationTree extends TreeAbstract {


    protected $_openParentTag = "<ol class=\"dd-list\">";

    protected $_closeParentTag = "</ol>";
    protected $_controller ;

    public function __construct( $navcontroller) {
        $this->_controller = $navcontroller;
    }
    public function createTree( $rows, $parentId = 0 ) {

        return $this->_createTree( $rows );
    }


    protected function _openChildTag( $child){

        return "<li class=\"dd-item dd3-item\"  data-id=\"".$child->getId()."\">";

    }

    protected function _childHTML( $child ) {
        $url = $this->_controller->generateURL('navmenu_edit', array('id' => $child->getId(), 'position'=>$child->getPosition()));
       
            return    "

                            <div class=\"dd-handle dd3-handle\">Drag</div><div class=\"dd3-content\">
                                ".$child->getName()."
                                    <a href=\"".$url."\" class=\"label label-info\">edit -en</a>--
                                    <a href=\"".$url."/sr\" class=\"label label-info\">edit -sr</a>--
                                    <a href=\"".$url."/cir\" class=\"label label-info\">edit -cir</a>
                            </div>

                      ";

    }




}