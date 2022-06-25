<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'float')]
    private $tarif;

    #[ORM\Column(type: 'boolean')]
    private $isInterieur;

    #[ORM\OneToMany(mappedBy: 'equipement', targetEntity: EquipementGite::class)]
    private $equipementGites;

    public function __construct()
    {
        $this->equipementGites = new ArrayCollection();
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

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function isIsInterieur(): ?bool
    {
        return $this->isInterieur;
    }

    public function setIsInterieur(bool $isInterieur): self
    {
        $this->isInterieur = $isInterieur;

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
            $equipementGite->setEquipement($this);
        }

        return $this;
    }

    public function removeEquipementGite(EquipementGite $equipementGite): self
    {
        if ($this->equipementGites->removeElement($equipementGite)) {
            // set the owning side to null (unless already changed)
            if ($equipementGite->getEquipement() === $this) {
                $equipementGite->setEquipement(null);
            }
        }

        return $this;
    }
}
