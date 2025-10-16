<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $monthlyPrice = null;

    #[ORM\Column]
    private ?int $dailyPrice = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $places = null;

    #[ORM\Column(length: 20)]
    private ?string $motor = null;

    #[ORM\Column(length: 140, unique: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMonthlyPrice(): ?int
    {
        return $this->monthlyPrice;
    }

    public function setMonthlyPrice(int $monthlyPrice): static
    {
        $this->monthlyPrice = $monthlyPrice;

        return $this;
    }

    public function getDailyPrice(): ?int
    {
        return $this->dailyPrice;
    }

    public function setDailyPrice(int $dailyPrice): static
    {
        $this->dailyPrice = $dailyPrice;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): static
    {
        $this->places = $places;

        return $this;
    }

    public function getMotor(): ?string
    {
        return $this->motor;
    }

    public function setMotor(string $motor): static
    {
        $this->motor = $motor;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Génère le slug à partir du nom :
     * - strtolower + trim pour nettoyer
     * - preg_replace('~[^a-z0-9]+~', '-') : remplace chaque suite de caractères non alphanumériques par un tiret
     *   (classe négative [^a-z0-9] + quantificateur +)
     * - trim des tirets de début/fin
     * Si le résultat est vide on conserve l'ancien slug.
     * (Accents simplement supprimés; ajouter une translittération si besoin.)
     */
    private function computeSlug(): void
    {
        if (!$this->name) {
            return;
        }
        $base = strtolower(trim($this->name));
        $base = preg_replace('~[^a-z0-9]+~', '-', $base);
        $base = trim($base, '-');
        $this->slug = $base ?: $this->slug;
    }

    public function getDailyPriceEuro(): ?float
    {
        return $this->dailyPrice !== null ? $this->dailyPrice / 100 : null;
    }

    public function getMonthlyPriceEuro(): ?float
    {
        return $this->monthlyPrice !== null ? $this->monthlyPrice / 100 : null;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $this->createdAt ?? $now;
        $this->updatedAt = $this->updatedAt ?? $now;
        $this->computeSlug();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
        $this->computeSlug();
    }
}
