<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Ingredient;

class IngredientManager
{

  private $em;
  private $repository;

  public function __construct(EntityManagerInterface $entityManager)
  {
    // Used to get repositories and presist objects
    $this->em = $entityManager;

    // Used to interact with entities (ingredients)
    $this->repository = $this->em
      ->getRepository(Ingredient::class);

  }

  public function create(string $name, ?string $description)
  {

    $ingredient = new Ingredient();

    $ingredient->setName($name);
    $ingredient->setDescription($description);

    $this->em->persist($ingredient);
    $this->em->flush();

    return($ingredient->getId());

  }

  public function read(int $id)
  {
    return($this->repository->find($id));
  }

  public function readAll()
  {
    return($this->repository->findAll());
  }

  public function update(int $id, string $name, ?string $description)
  {

    $ingredient = $this->read($id);

    $ingredient->setName($name);
    $ingredient->setDescription($description);

    $this->em->persist($ingredient);
    $this->em->flush();

    return($ingredient->getId());
  }

  public function delete(int $id)
  {
    // Not implemented
  }



}



















 ?>
