<?php

namespace App\Repository;

use App\Entity\Ligues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ligues|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ligues|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ligues[]    findAll()
 * @method Ligues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiguesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ligues::class);
    }

    // /**
    //  * @return Ligues[] Returns an array of Ligues objects
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
    public function findOneBySomeField($value): ?Ligues
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
