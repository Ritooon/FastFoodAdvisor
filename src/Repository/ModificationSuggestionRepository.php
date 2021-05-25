<?php

namespace App\Repository;

use App\Entity\ModificationSuggestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModificationSuggestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModificationSuggestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModificationSuggestion[]    findAll()
 * @method ModificationSuggestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModificationSuggestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModificationSuggestion::class);
    }

    // /**
    //  * @return ModificationSuggestion[] Returns an array of ModificationSuggestion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModificationSuggestion
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
