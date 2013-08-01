<?php

namespace Admin\NavMenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\NavMenuBundle\Entity\NavMenu;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        
//        $navMenu  = new NavMenu();
//        $navMenu->setName('zzzzzz');
//       $navMenu->setSort(1);
//        $navMenu->setUrl('http://blic.com');
//        $navMenu->setParentId(5);
//
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($navMenu);
//        $em->flush();
        
         
        $em = $this->getDoctrine()->getManager();
        $navMenu = $em->getRepository('NavMenuBundle:NavMenu')->findAllNMenu();

        
//        function buildTree(array $elements, $parentId = 0) {
//            
//            $branch = array();
//
//            foreach ($elements as $element) {
//                
//                $elParentId = $element->getParentId();
//                
//                if ($elParentId == $parentId) {
//                    
//                    $elId = $element->getId();
//                    
//                    $children = buildTree($elements, $elId);
//                    
//                    if ($children) {
//                        $element->setChildren($children);
//                    }
//                    
//                    $branch[] = $element;
//                }
//            }
//
//            return $branch;
//        }

    //$tree = buildTree($navMenu);
    $tree = $em->getRepository('NavMenuBundle:NavMenu')->getTree($navMenu);
    echo '<pre>'; var_dump($tree); die(); 
        
        return $this->render('NavMenuBundle:Default:index.html.twig', array('name' => $name));
    }
}
