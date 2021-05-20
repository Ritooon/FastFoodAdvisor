<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Restaurants;
use App\Entity\SearchRestaurant;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Restaurants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurants[]    findAll()
 * @method Restaurants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurants::class);
    }

    public function findAllNotDeletedWithPagination(SearchRestaurant $filter = null)
    {
        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.isDeleted = 0 OR r.isDeleted IS NULL')
        ;

        if($filter)
        {
            if($filter->getName()) {
                $qb->andWhere('r.name LIKE :name')
                    ->setParameter(':name', '%'.$filter->getName().'%');
            }

            if($filter->getCity()) {
                $qb->andWhere('r.city = :city')
                    ->setParameter(':city', $filter->getCity());
            }
        }

        $qb->orderBy('r.id', 'ASC')
            ->getQuery()
        ;

        return $qb;
    }

    public function getTopFive()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('(r.isDeleted = 0 OR r.isDeleted IS NULL)')
            ->orderBy('r.average_note', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMarkers($latMax, $longMax)
    {
        $latMin = floatval($latMax-0.5);
        $latMax = floatval($latMax+0.5);
        $lngMin = floatval($longMax-0.5);
        $lngMax = floatval($longMax+0.5);

        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.latitude > :latMin')
            ->andWhere('r.latitude < :latMax')
            ->andWhere('r.longitude > :longMin')
            ->andWhere('r.longitude < :longMax')
            ->andWhere('r.isApproved = 1')
            ->andWhere('(r.isDeleted = 0 OR r.isDeleted IS NULL)')
            ->setParameter('latMin', $latMin)
            ->setParameter('latMax', $latMax)
            ->setParameter('longMin', $lngMin)
            ->setParameter('longMax', $lngMax)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
        ;
    
        return $qb->getResult();
    }

    // /**
    //  * @return Restaurants[] Returns an array of Restaurants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restaurants
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
