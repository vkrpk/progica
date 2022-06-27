<?php

namespace App\Entity;

use App\Repository\ViewEquipementGiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ViewEquipementGiteRepository::class)]
#[ORM\Table(name:'view_equipement_gite')]
class ViewEquipementGite
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $gite_id;

    #[ORM\Column(type: 'integer')]
    private $equipement_id;

    #[ORM\Column(type: 'integer')]
    private $service_id;

    #[ORM\Column(type: 'string')]
    private $nom_equipement;

    #[ORM\Column(type: 'string')]
    private $nom_service;

    public function getNomEquipement(): ?string
    {
        return $this->nom_equipement;
    }

    public function setNomEquipement(string $nom_equipement): self
    {
        $this->nom_equipement = $nom_equipement;

        return $this;
    }

    public function getNomService(): ?string
    {
        return $this->nom_service;
    }

    public function setNomService(string $nom_service): self
    {
        $this->nom_service = $nom_service;

        return $this;
    }

    public function getEquipementId(): ?string
    {
        return $this->equipement_id;
    }

    public function setEquipementId(string $equipement_id): self
    {
        $this->equipement_id = $equipement_id;

        return $this;
    }

    public function getServiceId(): ?string
    {
        return $this->service_id;
    }

    public function setServiceId(string $service_id): self
    {
        $this->service_id = $service_id;

        return $this;
    }

    public function getGiteId(): ?int
    {
        return $this->gite_id;
    }

    public function setGiteId(string $gite_id): self
    {
        $this->gite_id = $gite_id;

        return $this;
    }

}