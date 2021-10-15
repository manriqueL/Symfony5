<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class RoleRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Role::class);
        $this->entityManager = $entityManager;
    }

    public function findForActionIndex($filtro = [])
    {
      $qb = $this->createQueryBuilder('e')
            ->orderBy("e.id", "ASC");

      if(isset($filtro["nombre"]) && $filtro["nombre"] != '') {
        $qb
          ->andWhere("e.roleName LIKE :nombre")
          ->setParameter("nombre", '%'.$filtro["nombre"].'%')
        ;
      }

      return $qb;
    }

    public function findByName($nombre)
    {
      $qb = $this->createQueryBuilder('e')
        ->andWhere("e.roleName = :nombre")
        ->setParameter("nombre", $nombre)
      ;

      return $qb->getQuery()->getOneOrNullResult();
    }

    public function delete(Role $role){
        try {
            $this->entityManager->remove($role);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
