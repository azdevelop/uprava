<?php

namespace Admin\NavMenuBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NavMenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NavMenuRepository extends EntityRepository
{
    public function findAllNMenu()
    {
        return $this->createQueryBuilder('u')
            ->addOrderBy('u.parentId ')
            ->addOrderBy('u.sort ')    
            ->getQuery()
            ->getResult()
        ;
    }
    

    public function updateParent(){

        $qb = $this->createQueryBuilder('u');
        $q = $qb->update()
            ->set(u.sort, 0)
            ->where('u.id = 2')
            ->getQuery();
        $p = $q->execute();
        return true;
    }

    public function findAllByLocale($locale = 'en'){
        //Make a Select query
        $qb = $this->createQueryBuilder('a');
        $qb->select('a');
        //->orderBy(...) customize it

        // Use Translation Walker
        $query = $qb->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        // Force the locale
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );
        return $query->getResult();
    }


    public function findByPosition($position, $locale = 'en'){

        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            ->where('a.position = :position')
            ->setParameter('position', $position)
        ;
        //->orderBy(...) customize it

        // Use Translation Walker
        $query = $qb->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        // Force the locale
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );
        return $query->getResult();
    }




    public function getTree( array $elements ) {
      
        return $this->_buildTree($elements);
        
    }


    private function _buildTree( array $elements, $parentId = 0 ){
        
        $branch = array();
        
        foreach ($elements as $element) { 
            
            $elParentId = $element->getParentId(); 

            if ($elParentId == $parentId) {

               $elId = $element->getId();

               $children = $this->_buildTree($elements, $elId);                   

               if ($children) {
                   
                   $element->setChildren($children);
                   
               }

               $branch[] = $element;
            }
        }
        
        return  $branch;
        
    }
    
}
