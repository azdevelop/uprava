<?php

namespace Admin\ArticleBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
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
    
    public function searchPostsBy( $q = ''){
       
        $q = trim($q);
        $qb = $this->createQueryBuilder('a');
        $qb->select('a');
        $qb->where('a.content LIKE :qst');
        $qb->orWhere('a.title LIKE :qst');
        $qb->setParameter('qst','%' . $q . '%');
        
        $query = $qb->getQuery();
        //var_dump($query->getSQL());die();
            return $query->getResult();


    }
    
    public function findByIdJoinedToCategory($cat){
//    $query = $this->getEntityManager()
//        ->createQuery('
//            SELECT p,pc, c FROM ArticleBundle:Post p
//            JOIN p.category c
//            WHERE p.id = :id'
//        )->setParameter('id', $id);
//
//    try {
//        return $query->getArrayResult();
//    } catch (\Doctrine\ORM\NoResultException $e) {
//        return null;
        
    }

    public function getLatest( $num ){

        $qb = $this->createQueryBuilder('p');
        $qb->select('p')
            ->setMaxResults( $num )
            ->orderBy('p.id', 'DESC');

        $query = $qb->getQuery();

        return $query->getResult();
    }

    
}
