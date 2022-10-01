<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Ride;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ride>
 *
 * @method Ride|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ride|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ride[]    findAll()
 * @method Ride[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ride::class);
    }

    public function add(Ride $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ride $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * Requete qui me permet de recuperer les produits en fonction de la recherche de l'utilisateur
     * @return Ride[]
     */
    public function findWithSearch(Search $search)
    {
        $query = $this
            ->createQueryBuilder('r')
            ->select('c', 'r')
            ->join('r.category', 'c')
            ->orderBy('r.departureDate', 'ASC');

        if(!empty($search->categories)){
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        if(!empty($search->date)) {
            $query = $query
                ->andWhere('r.departureDate > :date ')
                ->setParameter('date', $search->date);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * Requete qui me permet de recuperer les trajets en fonction de la date du poids et du chagement de personne
     * @return Ride[]
     */
    public function findGoodRide()
    {
        $now = new \DateTime(3 . ' days');
        $minWeight = 150;
        $minPeople = 1;
        $query = $this
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.departureDate > :date')
            ->andWhere('r.maxWeight >= :weight')
            ->andWhere('r.maxPeople >= :people')
            ->setParameter('date', $now)
            ->setParameter('weight', $minWeight )
            ->setParameter('people', $minPeople)
            ->orderBy('r.departureDate', 'ASC');
        return $query->getQuery()->getResult();
    }


//    /**
//     * @return Ride[] Returns an array of Ride objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ride
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
