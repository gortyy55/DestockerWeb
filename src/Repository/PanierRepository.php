<?php

namespace App\Repository;

use App\Entity\Enchere;
use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\BrowserKit\Response;

/**
 * @extends ServiceEntityRepository<Panier>
 *
 * @method Panier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panier[]    findAll()
 * @method Panier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
    }
    public function getPanierWithProduit(): array
    {
        $entityManager = $this->getEntityManager();

        // Execute the provided SQL query
        $query = $entityManager->createQuery(
            "SELECT p.idEnchere, p.prixtotal, en.produit
            FROM App\Entity\Panier p
            JOIN App\Entity\Enchere en WITH p.idEnchere = en.id"
        );

        return $query->getResult();
    }

    public function getAdminPanier(): array
    {
        $entityManager = $this->getEntityManager();

        // Execute the provided SQL query
        $query = $entityManager->createQuery(
            "SELECT p.idEnchere, p.prixtotal, p.idPanier ,p.idActeur ,p.dateEnchere ,en.produit
            FROM App\Entity\Panier p
            JOIN App\Entity\Enchere en WITH p.idEnchere = en.id"
        );

        return $query->getResult();
    }
//    /**
//     * @return Panier[] Returns an array of Panier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Panier
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
