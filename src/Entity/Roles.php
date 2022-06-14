<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'roles')]
    private $users;
/*
    #[ORM\ManyToMany(targetEntity: UserRoles::class, mappedBy: 'roles_id')]
    private $userRoles;
*/
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeRole($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
/*
    /**
     * @return Collection<int, UserRoles>
     */
/*
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(UserRoles $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addRolesId($this);
        }

        return $this;
    }

    public function removeUserRole(UserRoles $userRole): self
    {
        if ($this->userRoles->removeElement($userRole)) {
            $userRole->removeRolesId($this);
        }

        return $this;
    }
    */
}
