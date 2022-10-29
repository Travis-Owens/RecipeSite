<?php

namespace App\Entity;

use App\Repository\StepGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepGroupRepository::class)]
class StepGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'StepGroupId')]
    private Collection $recipes;

    #[ORM\OneToMany(mappedBy: 'stepGroup', targetEntity: Step::class)]
    private Collection $step;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->recipes = new ArrayCollection();
        $this->step = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
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
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->addStepGroupId($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): self
    {
        if ($this->recipes->removeElement($recipe)) {
            $recipe->removeStepGroupId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getStep(): Collection
    {
        return $this->step;
    }

    public function addStep(Step $step): self
    {
        if (!$this->step->contains($step)) {
            $this->step->add($step);
            $step->setStepGroup($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->step->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getStepGroup() === $this) {
                $step->setStepGroup(null);
            }
        }

        return $this;
    }
}
