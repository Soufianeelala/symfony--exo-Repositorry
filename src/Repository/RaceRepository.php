<?php

namespace App\Repository;

use App\Entity\Race;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Race>
 */
class RaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Race::class);
    }
   

//  /**
//      * Récupère toutes les races sous forme d'un tableau
//      * @return array
//      */
//     public function findAllRaces(): array
//     {
//         return $this->createQueryBuilder('r')
//             ->join('s.race', 'r') // Jointure avec l'entité Race

//             ->select('r.id, r.race_name')
//             ->orderBy('r.race_name', 'ASC') // Trie par nom de race
//             ->getQuery()
//             ->getArrayResult(); // Retourne un tableau associatif
//     }

    //    /**
    //     * @return Race[] Returns an array of Race objects
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

    //    public function findOneBySomeField($value): ?Race
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
