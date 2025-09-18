<?php

namespace App\Entity;

use App\Repository\EnvironnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnvironnementRepository::class)]
class Environnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\ManyToMany(targetEntity: Visite::class, mappedBy: 'environnements')]
    private Collection $no;

    public function __construct()
    {
        $this->no = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getNo(): Collection
    {
        return $this->no;
    }

    public function addNo(Visite $no): static
    {
        if (!$this->no->contains($no)) {
            $this->no->add($no);
            $no->addEnvironnement($this);
        }

        return $this;
    }

    public function removeNo(Visite $no): static
    {
        if ($this->no->removeElement($no)) {
            $no->removeEnvironnement($this);
        }

        return $this;
    }
}
