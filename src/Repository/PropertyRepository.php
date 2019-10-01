<?php
namespace App\Repository;


use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;


/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }


    /**
     * Retourne les enregistrements qui ne sont pas vendus.
     * Recuperer tous les biens qui ne sont pas vendus, cad ou solde = false
     * @param $search
     * @return Query
     * method where() enchainee ecrase s'ecrase les unes apres les autres
     * pour eviter cela il faut utiliser andWhere()
     */
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        $query = $this->findVisibleQuery();

        # traitement avec prix max
        if($maxprice = $search->getMaxPrice())
        {
            $query = $query->andWhere('p.price <= :maxprice')
                           ->setParameter('maxprice', $maxprice);
        }

        # traitement avec min surface
        if($minsurface = $search->getMinSurface())
        {
            $query = $query->andWhere('p.surface >= :minsurface')
                           ->setParameter('minsurface', $minsurface);
        }

        return $query->getQuery();
    }



    /**
     * Recuperer les 4 derniers resultats (setMaxResults)
     *  @return Property[] ( retourne un tableau de Property ]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
                    ->setMaxResults(4)
                    ->getQuery()
                    ->getResult();
    }


    /**
     * Get all query
     * @return QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
                    ->where('p.sold = false');
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        p : comme property ( nom de la table )
        return $this->createQueryBuilder('p')      // creer un object QueryBuilder
                    ->andWhere('p.exampleField = :val')
                    ->setParameter('val', $value)
                    ->orderBy('p.id', 'ASC')
                    ->setMaxResults(10)
                    ->getQuery() // recupere la requette
                    ->getResult(); // recupere le resultat
    }
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
