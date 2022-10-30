<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\StepGroup;

class StepGroupManager
{

  private $em;
  private $repository;

  public function __construct(EntityManagerInterface $entityManager)
  {

    // , StepManager $stepManager
    // Used to get repositories and presist objects
    $this->em = $entityManager;

    // Used to interact with entities (ingredients)
    $this->repository = $this->em
      ->getRepository(StepGroup::class);

  }

  public function create(?string $name, ?string $description)
  {

    $stepGroup = new StepGroup();

    $stepGroup->setName($name);
    $stepGroup->setDescription($description);

    $this->em->persist($stepGroup);
    $this->em->flush();

    return($stepGroup->getId());

  }

  public function read(int $id)
  {
    return($this->repository->find($id));
  }

  public function readAll()
  {
    return($this->repository->findAll());
  }

  public function update(int $id, ?string $name, ?string $description)
  {

    $stepGroup = $this->read($id);

    $stepGroup->setName($name);
    $stepGroup->setDescription($description);

    $this->em->persist($stepGroup);
    $this->em->flush();

    return($stepGroup->getId());
  }

  public function delete(int $id)
  {
    // Not implemented
  }

}
 ?>
