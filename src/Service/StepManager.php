<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Step;

class StepManager
{

  private $em;
  private $repository;

  private $ingredientManager;

  public function __construct(EntityManagerInterface $entityManager, IngredientManager $ingredientManager)
  {
    // Used to get repositories and presist objects
    $this->em = $entityManager;

    // Used to interact with entities (ingredients)
    $this->repository = $this->em
      ->getRepository(Step::class);

    // Used to interact with childern entities
    $this->ingredientManager = $ingredientManager;

  }

  public function create(?int $step_group_id, string $title, ?string $description, ?int $ingredient_id)
  {

    $step = new Step();

    // TODO: After step groups are implemented resolve this relation
    $step->setStepGroup(null);

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

    // TODO: After step groups are implemented resolve this relation
    $step->setStepGroup(null);

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
