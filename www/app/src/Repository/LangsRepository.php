<?php

namespace App\Repository;

use App\Entity\Langs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Langs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Langs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Langs[]    findAll()
 * @method Langs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LangsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Langs::class);
    }

    // /**
    //  * @return Langs[] Returns an array of Langs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Langs
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
