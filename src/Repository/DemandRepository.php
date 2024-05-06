<?php

namespace App\Repository;

use App\Entity\Demand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Demand>
 */
class DemandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demand::class);
    }

    /**
     * Example: Find demands by a specific property
     * Replace 'propertyName' with an actual property name of the Demand entity
     *
     * @return Demand[] Returns an array of Demand objects
     */
    public function findByPropertyName($value): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.propertyName = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Example: Find one demand by a specific property
     * Replace 'propertyName' with an actual property name of the Demand entity
     *
     * @return Demand|null Returns a single Demand object or null if not found
     */
    public function findOneByPropertyName($value): ?Demand
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.propertyName = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
