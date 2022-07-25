<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findBestSeries()
    {
        //en DQL
//        $entityManger = $this->getEntityManager();
//        $dql="
//            SELECT s
//            FROM App\Entity\Serie s
//            WHERE s.popularity > 80
//            AND s.vote > 7
//            ORDER BY s.popularity DESC";
//        $query = $entityManger->createQuery($dql);
//        $query->setMaxResults(10);
//        $results = $query->getResult();

        //en QueryBuilder
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder->leftJoin('s.seasons','seas')
            ->addSelect('seas');

        $queryBuilder->andWhere('s.popularity>90');
        $queryBuilder->andWhere('s.vote>8');
        $queryBuilder->addOrderBy('s.popularity','DESC');
        $query=$queryBuilder->getQuery();

        $query->setMaxResults(36);

        $paginator=new Paginator($query);
        return $paginator;

        //$results = $query->getResult();

        //return $results;
    }
}

/*
    public function add(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }*/
