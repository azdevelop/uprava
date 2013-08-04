<?php
namespace Admin\NavMenuBundle\Helpers\Tree;

abstract class TreeAbstract  {

    private $_navArray = array();

    protected $_openParentTag = "<ul>";

    protected $_closeParentTag = "</ul>";

    protected $_closeChildTag = "</li>";


    private function _checkChilds($rows, $id) {

        foreach ($rows as $row) {
            if ($row->getParentId() == $id) {
                return true;
            }
        }

        return false;

    }

    protected function _createTree($rows, $parent=0){

        $result = $this->_openParentTag;

        foreach ($rows as $row){

            if ($row->getParentId() == $parent){

                $result .= $this->_childHTML( $row );

                if ( $this->_checkChilds( $rows, $row->getId() ) ) {

                    $result.= $this->_createTree($rows, $row->getId() );

                }

                $result .= $this->_closeChildTag;
            }

        }

        $result .= $this->_closeParentTag;

        return $result;
    }



    protected abstract function _childHTML( $child );



    public function treeToArray($tree, $parentId = null) {


        foreach( $tree as $t ) {

            $this->_navArray[] = array( 'id' => $t['id'], 'parentId' => $parentId );

            if( isset( $t['children'] ) ) {
                $this->treeToArray( $t['children'], $t['id']);
            }

        }

        return $this->_navArray;

    }





}