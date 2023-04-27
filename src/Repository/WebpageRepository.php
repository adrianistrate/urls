<?php

namespace App\Repository;

use App\Entity\Webpage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Webpage>
 *
 * @method Webpage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Webpage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Webpage[]    findAll()
 * @method Webpage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebpageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Webpage::class);
    }

    public function save(Webpage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Webpage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function fetchByUrlData(?string $domain, ?string $pathname, ?array $queryParams): ?Webpage
    {
        $qb = $this->createQueryBuilder('w');

        if ($domain) {
            $qb
                ->andWhere('w.domain = :domain')
                ->setParameter('domain', $domain);
        }

        if ($pathname) {
            $qb
                ->andWhere('w.pathname = :pathname')
                ->setParameter('pathname', $pathname);
        }

        if ($queryParams) {
            $qb
                ->join('w.webpageParameters', 'wp')
                ->andWhere('wp.parameter IN (:queryParams)')
                ->setParameter('queryParams', $queryParams)
                ->groupBy('w.id')
                ->having('COUNT(DISTINCT wp.parameter) = :queryParamsCount')
                ->setParameter('queryParamsCount', count($queryParams));
        }

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    public
    function fetchRandom(): ?Webpage
    {
        return $this->createQueryBuilder('w')
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Webpage[] Returns an array of Webpage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Webpage
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
