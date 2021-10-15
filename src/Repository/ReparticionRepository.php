<?php

namespace App\Repository;

use App\Entity\Reparticion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class ReparticionRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Reparticion::class);
        $this->entityManager = $entityManager;
    }

    public function findForActionIndex($filtro = [])
    {
      $qb = $this->createQueryBuilder('e')
            ->orderBy("e.id", "ASC");

      if(isset($filtro["nombre"]) && $filtro["nombre"] != '') {
        $qb
          ->andWhere("e.nombre LIKE :nombre")
          ->setParameter("nombre", '%'.$filtro["nombre"].'%')
        ;
      }

      return $qb;
    }

    public function delete(Reparticion $reparticion){
        try {
            $this->entityManager->remove($reparticion);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
