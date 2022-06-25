<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'Service', targetEntity: GiteService::class)]
    private $giteServices;

    public function __construct()
    {
        $this->giteServices = new ArrayCollection();
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
     * @return Collection<int, GiteService>
     */
    public function getGiteServices(): Collection
    {
        return $this->giteServices;
    }

    public function addGiteService(GiteService $giteService): self
    {
        if (!$this->giteServices->contains($giteService)) {
            $this->giteServices[] = $giteService;
            $giteService->setService($this);
        }

        return $this;
    }

    public function removeGiteService(GiteService $giteService): self
    {
        if ($this->giteServices->removeElement($giteService)) {
            // set the owning side to null (unless already changed)
            if ($giteService->getService() === $this) {
                $giteService->setService(null);
            }
        }

        return $this;
    }
}
