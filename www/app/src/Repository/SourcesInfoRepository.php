<?php

namespace App\Repository;

use App\Entity\SourcesInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SourcesInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method SourcesInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method SourcesInfo[]    findAll()
 * @method SourcesInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SourcesInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SourcesInfo::class);
    }

    // /**
    //  * @return SourcesInfo[] Returns an array of SourcesInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SourcesInfo
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
