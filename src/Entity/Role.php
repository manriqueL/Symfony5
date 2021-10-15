<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $roleName;

    /**
     * @ORM\OneToMany(targetEntity=Permiso::class, mappedBy="role")
     */
    private $permisos;

    public function __construct()
    {
        $this->permisos = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): self
    {
        $this->roleName = $roleName;

        return $this;
    }

    public function __toString() {
        return $this->roleName;
    }

    /**
     * @return Collection|Permiso[]
     */
    public function getPermisos(): Collection
    {
        return $this->permisos;
    }

    public function addPermiso(Permiso $permiso): self
    {
        if (!$this->permisos->contains($permiso)) {
            $this->permisos[] = $permiso;
            $permiso->setRole($this);
        }

        return $this;
    }

    public function removePermiso(Permiso $permiso): self
    {
        if ($this->permisos->contains($permiso)) {
            $this->permisos->removeElement($permiso);
            // set the owning side to null (unless already changed)
            if ($permiso->getRole() === $this) {
                $permiso->setRole(null);
            }
        }

        return $this;
    }
}
