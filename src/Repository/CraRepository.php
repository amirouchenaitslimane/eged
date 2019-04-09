<?php

namespace App\Repository;

use App\Entity\Cra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cra|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cra|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cra[]    findAll()
 * @method Cra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CraRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cra::class);
    }

    // /**
    //  * @return Cra[] Returns an array of Cra objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cra
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

  public function findByDate($start, $end='2019-02-28')
  {
    $em=$this->getEntityManager();

    return $em->getRepository(Cra::class)
      ->createQueryBuilder("c")
      ->leftJoin("c.client", "cl")
      ->where('c.date BETWEEN :start AND :end')
      ->setParameter('start',$start)
      ->setParameter('end',$end)
      ->getQuery()
      ->getResult();
  }
}
