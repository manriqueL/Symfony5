<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\PermisoRepository;
use App\Repository\RoleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $permisoRepository;
    private $roleRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder, PermisoRepository $permisoRepository, RoleRepository $roleRepository)
    {
        $this->encoder = $userPasswordEncoder;
        $this->permisoRepository = $permisoRepository;
        $this->roleRepository = $roleRepository;
    }

    public function load(ObjectManager $manager)
    {
        /* Crea el rol superuser */
        $roles = [
            "ROLE_SUPERUSER" => "Super Admin"
        ];
        foreach ($roles as $key => $value) {
            if (!$manager->getRepository(Role::class)->findByRoleName([$key])) {
                $role = new Role();
                $role->setRoleName($key);
                $manager->persist($role);
                $manager->flush();
            }
        }

        /* Le asigna los permisos básicos al rol superuser */
        $rol = $this->roleRepository->findByName("ROLE_SUPERUSER");
        $permisos = array("ADMINISTRACION", "VER_INICIO", "ROLES_VER", "ROLES_EDITAR");
        $this->permisoRepository->asignarRoles($rol, $permisos);

        /* Crea el usuario admin con el rol superuser */
        $user = new User();
        if (!$manager->find(User::class, 1)) {
            $user->setUsername('admin');
            $user->setRoles(["ROLE_SUPERUSER"]);
            $user->setPassword($this->encoder->encodePassword($user, 'admin'));
            $user->setNombre('Admin');
            $user->setApellido('Admin');
            $user->setEmail('admin@example.com');
            $user->setSuspended(false);
            $user->setDeleted(false);
            $manager->persist($user);

            $manager->flush();
            


        }

    }

}
