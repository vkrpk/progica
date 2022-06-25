<?php

namespace App\Entity;

use App\Repository\GiteServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GiteServiceRepository::class)]
class GiteService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Gite::class, inversedBy: 'giteServices')]
    private $gite;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'giteServices')]
    private $service;

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

    public function getService(): ?service
    {
        return $this->service;
    }

    public function setService(?service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
