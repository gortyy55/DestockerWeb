<?php

namespace App\Repository;

use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    // Example custom method
    public function findAverageRatingByStock($stockId)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.stock = :stockId')
            ->setParameter('stockId', $stockId)
            ->select('avg(r.rating) as averageRating')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
