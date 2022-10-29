<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: StepGroup::class, inversedBy: 'recipes')]
    private Collection $StepGroupId;

    #[ORM\ManyToMany(targetEntity: RecipeCategory::class, inversedBy: 'recipes')]
    private Collection $RecipeCategoryId;

    public function __construct()
    {
        $this->StepGroupId = new ArrayCollection();
        $this->RecipeCategoryId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, StepGroup>
     */
    public function getStepGroupId(): Collection
    {
        return $this->StepGroupId;
    }

    public function addStepGroupId(StepGroup $stepGroupId): self
    {
        if (!$this->StepGroupId->contains($stepGroupId)) {
            $this->StepGroupId->add($stepGroupId);
        }

        return $this;
    }

    public function removeStepGroupId(StepGroup $stepGroupId): self
    {
        $this->StepGroupId->removeElement($stepGroupId);

        return $this;
    }

    /**
     * @return Collection<int, RecipeCategory>
     */
    public function getRecipeCategoryId(): Collection
    {
        return $this->RecipeCategoryId;
    }

    public function addRecipeCategoryId(RecipeCategory $recipeCategoryId): self
    {
        if (!$this->RecipeCategoryId->contains($recipeCategoryId)) {
            $this->RecipeCategoryId->add($recipeCategoryId);
        }

        return $this;
    }

    public function removeRecipeCategoryId(RecipeCategory $recipeCategoryId): self
    {
        $this->RecipeCategoryId->removeElement($recipeCategoryId);

        return $this;
    }
}
