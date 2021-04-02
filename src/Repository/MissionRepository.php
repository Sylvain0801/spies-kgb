<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    public function searchMissionByWords($words = null, $statute = null, $nationality = null) {
        $qb = $this->createQueryBuilder('m');
        if($words != null) {
            $qb->where('MATCH_AGAINST(m.title, m.description, m.code_name, m.type) AGAINST(:words boolean)>0')
                ->setParameter('words', $words);
        }
        if($statute != null) {
            $qb->leftJoin('m.statute', 's');
            $qb->andWhere('s.id = :id')
                ->setParameter('id', $statute);
        }
        if($nationality != null) {
            $qb->leftJoin('m.nationality', 'n');
            $qb->andWhere('n.id = :id')
                ->setParameter('id', $nationality);
        }
        
        return $qb->getQuery()->getResult();
   }

    // /**
    //  * @return Mission[] Returns an array of Mission objects
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
    public function findOneBySomeField($value): ?Mission
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
