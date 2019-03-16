<?php

namespace App\Repository;

use App\Entity\Frais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Frais|null find($id, $lockMode = null, $lockVersion = null)
 * @method Frais|null findOneBy(array $criteria, array $orderBy = null)
 * @method Frais[]    findAll()
 * @method Frais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Frais::class);
    }
  public function findByDate($start, $end='2019-02-28')
  {

    $entityManager = $this->getEntityManager();
    $q = $entityManager->createQuery('
    SELECT f FROM App\Entity\Frais f WHERE f.date BETWEEN :start and :end order by f.date ASC 
    ')->setParameter('start',$start)->setParameter('end',$end);
    return $q->execute();
  }




    // /**
    //  * @return Frais[] Returns an array of Frais objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Frais
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
