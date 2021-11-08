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

    public function findAll(){
      $qb = $this->createQueryBuilder('e');
      return $qb->getQuery()->getResult();
    }

    public function findUsersByRole($rol)
    {
      //dd($rol->getRoleName());
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles = :val')
            ->setParameter('val', )
            ->getQuery()
            ->getResult();
    }

    public function findForActionIndex($filtro = [])
    {
      $qb = $this->createQueryBuilder('e')
            ->andWhere("e.roleName != 'ROLE_SUPERUSER'")
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

    public function findExceptAdmin(){
      $qb = $this->createQueryBuilder('r')
        ->andWhere("r.roleName != 'ROLE_SUPERUSER'")
        ->orderBy('r.roleName', 'ASC')
      ;

      return $qb;
    }

    public function findRepetido($value): ?Role
    {
      $roleName = $value->getRoleName();
      $id = $value->getId();
        return $this->createQueryBuilder('u')
            ->andWhere('u.roleName = :roleName')
            ->andWhere('u.id != :id')
            ->setParameter('roleName', $roleName)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
