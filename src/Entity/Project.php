<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    use Timestamps;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_utworzenia = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_aktualizacji = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function __toString() {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDataUtworzenia(): ?\DateTimeInterface
    {
        return $this->data_utworzenia;
    }

    public function setDataUtworzenia(?\DateTimeInterface $data_utworzenia): static
    {
        $this->data_utworzenia = $data_utworzenia;

        return $this;
    }

    public function getDataAktualizacji(): ?\DateTimeInterface
    {
        return $this->data_aktualizacji;
    }

    public function setDataAktualizacji(?\DateTimeInterface $data_aktualizacji): static
    {
        $this->data_aktualizacji = $data_aktualizacji;

        return $this;
    }
}
