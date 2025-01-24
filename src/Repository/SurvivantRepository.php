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
            
      /**
     * Récupérer les survivants par une race donnée. viaa la formulaire
     * @param string $raceName
     * @return Survivant[]
     */
    public function findByCriteria(array $criteria)
    {
        // Création d'une requête de base avec le QueryBuilder
        // Le QueryBuilder permet de construire des requêtes SQL dynamiques.
        $qb = $this->createQueryBuilder('s')
                   ->leftJoin('s.race', 'r') // Assure-toi de joindre correctement la table race
                   ->addSelect('r') // Permet d'ajouter les informations sur la race
                   ->leftJoin('s.classe', 'c') // Joindre la table des classes
                   ->addSelect('c'); // Ajouter les classes pour la requête
                   
    
        // Filtrer par race (si défini dans les critères)
        if (isset($criteria['race']) && $criteria['race'] !== null) {
            // Si un critère 'race' est fourni, on l'ajoute à la requête.
            $qb->andWhere('r.race_name = :race') // Assure-toi que "raceName" est le bon champ dans ta table "race"
               ->setParameter('race', $criteria['race']); // On assigne la valeur de la race passée dans les critères
        }
    
        // Filtrer par puissance (si défini dans les critères)
        if (isset($criteria['puissance']) && $criteria['puissance'] !== null) {
            // Si un critère 'puissance' est fourni, on l'ajoute à la requête.
            $qb->andWhere('s.puissance >= :puissance') // Filtrage sur le champ "puissance" de la table "survivant"
               ->setParameter('puissance', $criteria['puissance']); // On assigne la valeur de la puissance passée dans les critères
        }
        if (isset($criteria['class_name']) && !empty($criteria['class_name'])) {
            $qb->andWhere('s.class_name = :class_name')
               ->setParameter('class_name', $criteria['class_name']);
        }
        
    
        // Retourner les résultats de la requête
        // La méthode getQuery() génère la requête SQL basée sur le QueryBuilder et getResult() exécute la requête.
        return $qb->getQuery()->getResult();
    }


                    //Puissance Cumulée par Race


    public function getRacesWithTotalPower(): array
    {
        // Construire la requête avec le QueryBuilder
        return $this->createQueryBuilder('s') // Alias pour l'entité "Survivant"
            ->select('r.race_name AS race', 'SUM(s.puissance) AS totalPower') // Sélectionner le nom de la race et la somme des puissances
            ->leftJoin('s.race', 'r') // Faire une jointure entre les survivants et leurs races
            ->groupBy('r.race_name') // Grouper par nom de race
            ->orderBy('totalPower', 'DESC') // Trier les résultats par puissance cumulée, décroissante
            ->getQuery() // Générer la requête
            ->getResult(); // Exécuter et retourner les résultats
    }
    
    
}
