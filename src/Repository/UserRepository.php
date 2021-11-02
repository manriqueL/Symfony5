<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{

    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $entityManager;
    }

    public function saveUser($user):User
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function findOneByUsernameOrEmail($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val or u.username = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findForActionIndex($filtro = [])
    {
      $qb = $this->createQueryBuilder('e');

      if(isset($filtro["nombre"]) && $filtro["nombre"] != '') {
        $qb
          ->andWhere("e.nombre LIKE :nombre")
          ->setParameter("nombre", '%'.$filtro["nombre"].'%')
        ;
      }
      if(isset($filtro["username"]) && $filtro["username"] != '') {
        $qb
          ->andWhere("e.username LIKE :username")
          ->setParameter("username", '%'.$filtro["username"].'%')
        ;
      }
      if(isset($filtro["email"]) && $filtro["email"] != '') {
        $qb
          ->andWhere("e.email LIKE :email")
          ->setParameter("email", '%'.$filtro["email"].'%')
        ;
      }

      return $qb;
    }

    public function delete(User $user){
        /* $user->setDeleted(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user; */
        try {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function changeValidite(User $user){
      if ($user->getSuspended())
          $user->setSuspended(false);
      else
          $user->setSuspended(true);
      $this->entityManager->persist($user);
      $this->entityManager->flush();
      return $user;
  }
}
