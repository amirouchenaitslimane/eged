<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
  public function __construct(RegistryInterface $registry)
  {
    parent::__construct($registry, Client::class);
  }

  // /**
  //  * @return Client[] Returns an array of Client objects
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
  public function findOneBySomeField($value): ?Client
  {
      return $this->createQueryBuilder('c')
          ->andWhere('c.exampleField = :val')
          ->setParameter('val', $value)
          ->getQuery()
          ->getOneOrNullResult()
      ;
  }
  */

//  public function findByDate($start, $end='2019-02-28')
//  {
//    return $this->createQueryBuilder('c')
//          ->leftJoin('c.cras','cr')
//           ->where('c.id = cr.client')
//           ->where('cr.date between :start AND :end')
//
//
//      ->setParameter('start', $start)
//      ->setParameter('end', $end)
//      ->orderBy('c.id', 'ASC')
//
//      ->getQuery()
//      ->getResult()
//      ;
//
//  }
  public function findByDate($start, $end)
  {
    $em=$this->getEntityManager();

    return $em->getRepository(Client::class)
      ->createQueryBuilder("c")
      ->Join("c.cras", "cr")
      ->where('cr.date BETWEEN :start AND :end')
      ->setParameter('start',$start)
      ->setParameter('end',$end)
      ->getQuery()
      ->execute();
  }
}