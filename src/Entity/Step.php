<?php

namespace App\Entity;

use App\Repository\StepRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepRepository::class)]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StepGroup $StepId = null;

    #[ORM\ManyToOne]
    private ?Ingredient $IngredientId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStepId(): ?StepGroup
    {
        return $this->StepId;
    }

    public function setStepId(?StepGroup $StepId): self
    {
        $this->StepId = $StepId;

        return $this;
    }

    public function getIngredientId(): ?Ingredient
    {
        return $this->IngredientId;
    }

    public function setIngredientId(?Ingredient $IngredientId): self
    {
        $this->IngredientId = $IngredientId;

        return $this;
    }
}
