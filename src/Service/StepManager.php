<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Step;

class StepManager
{

  private $em;
  private $repository;

  private $ingredientManager;
  private $stepGroupManager;

  public function __construct(EntityManagerInterface $entityManager, StepGroupManager $stepGroupManager, IngredientManager $ingredientManager)
  {
    // Used to get repositories and presist objects
    $this->em = $entityManager;

    // Used to interact with entities (ingredients)
    $this->repository = $this->em
      ->getRepository(Step::class);

    // Used to interact with childern entities
    $this->ingredientManager = $ingredientManager;

    // Used to interact with parent entities
    $this->stepGroupManager = $stepGroupManager;

  }

  public function create(?int $step_group_id, string $title, ?string $description, ?int $ingredient_id)
  {

    $step = new Step();

    // Find the associated step group entity
    $stepGroup = $this->stepGroupManager->read($step_group_id);

    $step->setStepGroup($stepGroup);

    $step->setTitle($title);
    $step->setDescription($description);

    // Find the associated ingredient
    $step->setIngredient($this->ingredientManager->read($ingredient_id));

    $this->em->persist($step);
    $this->em->flush();

    return($step->getId());

  }

  public function read(int $id)
  {
    return($this->repository->find($id));
  }

  public function readAll()
  {
    return($this->repository->findAll());
  }

  public function update(int $id, ?int $step_group_id, string $title, ?string $description, ?int $ingredient_id)
  {

    $step = $this->read($id);

    // Find the associated step group entity
    $stepGroup = $this->stepGroupManager->read($step_group_id);

    $step->setStepGroup($stepGroup);

    $step->setTitle($title);
    $step->setDescription($description);

    // Find the associated ingredient
    $step->setIngredient($this->ingredientManager->read($ingredient_id));


    $this->em->persist($step);
    $this->em->flush();

    return($step->getId());
  }

  public function delete(int $id)
  {
    // Not implemented
  }

}
 ?>
