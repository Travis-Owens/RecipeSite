<?php

namespace App\Entity;

use App\Repository\RecipeStepRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeStepRepository::class)]
class RecipeStep
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'recipeSteps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?recipe $recipeID = null;

    #[ORM\ManyToOne(inversedBy: 'recipeSteps')]
    private ?ingredient $ingredientID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
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

    public function getRecipeID(): ?recipe
    {
        return $this->recipeID;
    }

    public function setRecipeID(?recipe $recipeID): self
    {
        $this->recipeID = $recipeID;

        return $this;
    }

    public function getIngredientID(): ?ingredient
    {
        return $this->ingredientID;
    }

    public function setIngredientID(?ingredient $ingredientID): self
    {
        $this->ingredientID = $ingredientID;

        return $this;
    }
}
