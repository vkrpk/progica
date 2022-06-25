<?php

namespace App\Entity;

use App\Repository\EquipementGiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementGiteRepository::class)]
class EquipementGite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Gite::class, inversedBy: 'equipementGites')]
    private $gite;

    #[ORM\ManyToOne(targetEntity: Equipement::class, inversedBy: 'equipementGites')]
    private $equipement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGite(): ?gite
    {
        return $this->gite;
    }

    public function setGite(?gite $gite): self
    {
        $this->gite = $gite;

        return $this;
    }

    public function getEquipement(): ?equipement
    {
        return $this->equipement;
    }

    public function setEquipement(?equipement $equipement): self
    {
        $this->equipement = $equipement;

        return $this;
    }
}
