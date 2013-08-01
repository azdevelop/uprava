<?php
namespace Admin\NavMenuBundle\Helpers;

class Tree {
    
    
    private function _checkChilds($rows, $id) {
        foreach ($rows as $row) {
            if ($row->getParentId() == $id) {
                return true;
            }
        }
        return false;
    }
    
    public function createMenu($rows, $parent=0){  

        $result = "<ul>";

        foreach ($rows as $row){
            if ($row->getParentId() == $parent){

                if( $row->getUrl() ){
                    $result .= "<li><a href='".$row->getUrl()."' />".$row->getName()."</a> 
                        --- <a href=\"http://localhost/symfony/web/app_dev.php/navmenu/".$row->getId()."/edit\" >edit</a>\n";
                } else {
                    $result .= "<li>".$row->getName()."\n";
                }
                if ( $this->_checkChilds( $rows, $row->getId() ) ) {
                    $result.= $this->createMenu($rows, $row->getId() );
                }
                $result .= "</li>\n";
            }
        }

        $result .= "</ul>\n";

        return $result;
    }
}