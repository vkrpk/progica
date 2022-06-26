<?php

namespace App\Entity;

use App\Repository\GiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GiteRepository::class)]
class Gite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $surface;

    #[ORM\Column(type: 'integer')]
    private $chambre;

    #[ORM\Column(type: 'integer')]
    private $couchage;

    #[ORM\Column(type: 'datetime')]
    private $horaire;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'gites')]
    private $ville;

    #[ORM\ManyToOne(targetEntity: Periode::class, inversedBy: 'gites')]
    private $periode;

    #[ORM\OneToMany(mappedBy: 'gite', targetEntity: EquipementGite::class)]
    private $equipementGites;

    #[ORM\OneToMany(mappedBy: 'gite', targetEntity: GiteService::class)]
    private $giteServices;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    public function __construct()
    {
        $this->equipementGites = new ArrayCollection();
        $this->giteServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getChambre(): ?int
    {
        return $this->chambre;
    }

    public function setChambre(int $chambre): self
    {
        $this->chambre = $chambre;

        return $this;
    }

    public function getCouchage(): ?int
    {
        return $this->couchage;
    }

    public function setCouchage(int $couchage): self
    {
        $this->couchage = $couchage;

        return $this;
    }

    public function getHoraire(): ?\DateTimeInterface
    {
        return $this->horaire;
    }

    public function setHoraire(\DateTimeInterface $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getVille(): ?ville
    {
        return $this->ville;
    }

    public function setVille(?ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPeriode(): ?periode
    {
        return $this->periode;
    }

    public function setPeriode(?periode $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    /**
     * @return Collection<int, EquipementGite>
     */
    public function getEquipementGites(): Collection
    {
        return $this->equipementGites;
    }

    public function addEquipementGite(EquipementGite $equipementGite): self
    {
        if (!$this->equipementGites->contains($equipementGite)) {
            $this->equipementGites[] = $equipementGite;
            $equipementGite->setGite($this);
        }

        return $this;
    }

    public function removeEquipementGite(EquipementGite $equipementGite): self
    {
        if ($this->equipementGites->removeElement($equipementGite)) {
            // set the owning side to null (unless already changed)
            if ($equipementGite->getGite() === $this) {
                $equipementGite->setGite(null);
            }
        }

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
            $giteService->setGite($this);
        }

        return $this;
    }

    public function removeGiteService(GiteService $giteService): self
    {
        if ($this->giteServices->removeElement($giteService)) {
            // set the owning side to null (unless already changed)
            if ($giteService->getGite() === $this) {
                $giteService->setGite(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
