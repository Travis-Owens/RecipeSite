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

    #[ORM\ManyToMany(targetEntity: RecipeCategory::class, inversedBy: 'recipes')]
    private Collection $categoryID;

    #[ORM\OneToMany(mappedBy: 'recipeID', targetEntity: RecipeStep::class, orphanRemoval: true)]
    private Collection $recipeSteps;

    public function __construct()
    {
        $this->categoryID = new ArrayCollection();
        $this->recipeSteps = new ArrayCollection();
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
     * @return Collection<int, RecipeCategory>
     */
    public function getCategoryID(): Collection
    {
        return $this->categoryID;
    }

    public function addCategoryID(RecipeCategory $categoryID): self
    {
        if (!$this->categoryID->contains($categoryID)) {
            $this->categoryID->add($categoryID);
        }

        return $this;
    }

    public function removeCategoryID(RecipeCategory $categoryID): self
    {
        $this->categoryID->removeElement($categoryID);

        return $this;
    }

    /**
     * @return Collection<int, RecipeStep>
     */
    public function getRecipeSteps(): Collection
    {
        return $this->recipeSteps;
    }

    public function addRecipeStep(RecipeStep $recipeStep): self
    {
        if (!$this->recipeSteps->contains($recipeStep)) {
            $this->recipeSteps->add($recipeStep);
            $recipeStep->setRecipeID($this);
        }

        return $this;
    }

    public function removeRecipeStep(RecipeStep $recipeStep): self
    {
        if ($this->recipeSteps->removeElement($recipeStep)) {
            // set the owning side to null (unless already changed)
            if ($recipeStep->getRecipeID() === $this) {
                $recipeStep->setRecipeID(null);
            }
        }

        return $this;
    }

}
