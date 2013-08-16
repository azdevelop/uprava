<?php
namespace Admin\AplicationBundle\Entity;

use Doctrine\ORM\EntityRepository;
use DoctrineDBALDriverManager;

class ActivityLogRepository extends EntityRepository {

    public function getActivityLogs( $userId ){


        return $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.user = :userId')
            ->setParameter('userId', $userId)
            ->addOrderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()   ;

        /*
        $config = new \Doctrine\DBAL\Configuration();

        $connectionParams = array(
            'dbname' => 'yoda_event',
            'user' => 'root',
            'password' => '123123',
            'host' => '127.0.0.1',
            'driver' => 'pdo_mysql',
        );


        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        $stmt = $conn->prepare("SELECT * FROM User ");
        $stmt->execute();

        return $stmt->fetchAll();

        */


    }

}
