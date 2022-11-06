<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Recipe;

class RecipeManager
{

  private $em;
  private $repository;

  private $stepGroupManager;

  public function __construct(EntityManagerInterface $entityManager, StepGroupManager $stepGroupManager)
  {

    // Used to get repositories and presist objects
    $this->em = $entityManager;

    // Used to interact with entities (ingredients)
    $this->repository = $this->em
      ->getRepository(Recipe::class);

    // Used to manage step groups associated with the recipe
    $this->stepGroupManager = $stepGroupManager;

  }

  public function create(?string $name, ?string $description, ?array $stepGroups)
  {

    $recipe = new Recipe();

    $recipe->setName($name);
    $recipe->setDescription($description);

    // Add step groups to the recipe
    foreach ($stepGroups as $key => $value) {
      $recipe->addStepGroupId($this->stepGroupManager->read($stepGroups[$key]["id"]));
    }

    $this->em->persist($recipe);
    $this->em->flush();

    return($recipe->getId());

  }

  public function read(int $id)
  {
    return($this->repository->find($id));
  }

  public function readAll()
  {
    return($this->repository->findAll());
  }

  public function update(int $id, ?string $name, ?string $description, ?array $stepGroups)
  {

    $recipe = $this->read($id);

    $recipe->setName($name);
    $recipe->setDescription($description);

    // Clear existing step groups
    foreach ($recipe->getStepGroupId() as $key => $value) {
      $recipe->removeStepGroupId($value);
    }

    // Add step groups to the recipe
    foreach ($stepGroups as $key => $value) {
      $recipe->addStepGroupId($this->stepGroupManager->read($stepGroups[$key]["id"]));
    }


    $this->em->persist($recipe);
    $this->em->flush();

    return($recipe->getId());
  }

  public function delete(int $id)
  {
    // Not implemented
  }

}
 ?>
