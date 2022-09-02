<?php

namespace App\Entity;

use App\Repository\AdhesionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdhesionsRepository::class)]
class Adhesions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $starting_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $ending_date = null;

    #[ORM\ManyToOne(inversedBy: 'adhesions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adherents $adherent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->starting_date;
    }

    public function setStartingDate(\DateTimeInterface $starting_date): self
    {
        $this->starting_date = $starting_date;

        return $this;
    }

    public function getEndingDate(): ?\DateTimeInterface
    {
        return $this->ending_date;
    }

    public function setEndingDate(\DateTimeInterface $ending_date): self
    {
        $this->ending_date = $ending_date;

        return $this;
    }

    public function getAdherent(): ?Adherents
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherents $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }
}
