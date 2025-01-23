<?php

namespace App\Repository;
use App\Entity\race;

use App\Entity\Survivant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Survivant>
 */
class SurvivantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Survivant::class);
    }

    //    /**
    //     * @return Survivant[] Returns an array of Survivant objects
    //     */
       public function findByExampleField(): array
       {
           return $this->createQueryBuilder('s')
               //->andWhere('s.exampleField = :val')
               //->setParameter('val', $value)
               ->orderBy('s.nom', 'DESC')
               //->setMaxResults(10)
               ->getQuery()
               ->getResult();
           
       }

       public function Nain($value): array //?Survivant
       {
           return $this->createQueryBuilder('s') // 's' pour Survivant
               ->leftJoin('s.race', 'r') // Jointure avec l'entité Race
               ->andWhere('r.race_name = :Nain') //  le nom de la race
               ->setParameter('Nain', $value) // Définit la valeur pour :Nain
               ->getQuery()
               ->getResult();
            }


            public function puissance($value): array
            {
                return $this->createQueryBuilder('s') // 's' pour Survivant
                    ->leftJoin('s.race', 'r') // Jointure avec l'entité Race
                    ->andWhere('s.puissance >= :value') // Comparaison avec >=
                    ->andWhere('r.race_name = :race') // Condition pour la race "Elfe"
                    ->setParameter('value', $value) // Définit le paramètre
                    ->setParameter('race', 'Elfe') // Définit le paramètre pour la race
                    ->getQuery()
                    ->getResult();
            }
            public function NonHumain(): array
            {
                return $this->createQueryBuilder('s') // 's' pour Survivant
                    ->leftJoin('s.race', 'r') // Jointure avec l'entité Race
                    ->andWhere('r.race_name != :race') // Exclure "Humain"
                    ->setParameter('race', 'Humain') // Définir le paramètre "Humain"
                    ->getQuery()
                    ->getResult(); // Retourne un tableau de Survivants
            }
            
            ///filter par name race via une formulaire 
            public function findByRaceName(string $raceName): array
            {
                return $this->createQueryBuilder('s') // 's' représente l'entité Survivant
                    ->leftJoin('s.race', 'r') // Jointure avec l'entité Race
                    ->andWhere('r.nom = :raceName') // Filtre sur le nom de la race
                    ->setParameter('raceName', $raceName) // Définit le paramètre
                    ->getQuery()
                    ->getResult(); // Retourne un tableau de Survivants
            }
 

}
