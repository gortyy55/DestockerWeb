<?php

namespace App\Repository;

use App\Entity\Stockp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stockp>
 *
 * @method Stockp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stockp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stockp[]    findAll()
 * @method Stockp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stockp::class);
    }

//    /**
//     * @return Stockp[] Returns an array of Stockp objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Stockp
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
