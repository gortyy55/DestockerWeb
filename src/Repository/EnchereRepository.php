<?php

namespace App\Repository;

use App\Entity\Enchere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Enchere>
 *
 * @method Enchere|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enchere|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enchere[]    findAll()
 * @method Enchere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnchereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enchere::class);
    }

    public function findAllSpecificAttributes(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.id,e.produit, e.prixactuel, e.stock')
            ->getQuery()
            ->getResult();
    }



//    /**
//     * @return Enchere[] Returns an array of Enchere objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Enchere
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
