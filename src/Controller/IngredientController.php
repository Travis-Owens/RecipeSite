<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Service\IngredientManager;

class IngredientController extends AbstractController
{

    private IngredientManager $IngredientManager;
    private Serializer $serializer;

    public function __construct(IngredientManager $IngredientManager) {

      // IngredientManager is used to interact with the ingredient entities
      $this->IngredientManager = $IngredientManager;

      // Serializer is used for the API routes; converts entities to JSON
      $encoders = [new XmlEncoder(), new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];
      $this->serializer = new Serializer($normalizers, $encoders);

    }

    #[Route('/ingredient', methods: ['GET', 'HEAD'])]
    public function readAll(): Response
    {
      $ingredients = $this->IngredientManager->readAll();

      return $this->render('container.html.twig', [
          'template' => 'ingredient/readAll.html.twig',
          'ingredients' => $ingredients
      ]);
    }

    #[Route('/ingredient/read/{id}',  methods: ['GET'])]
    public function read(?int $id): Response
    {
      // Find the ingredient requested
      $ingredient = $this->IngredientManager->read($id);

      return $this->render('ingredient/read.html.twig', [
          'controller_name' => 'IngredientController',
          'ingredient' => $ingredient
      ]);
    }

    #[Route('/ingredient/create',  methods: ['GET'])]
    public function create(?int $id): Response
    {
      return $this->render('container.html.twig', [
          'template' => 'ingredient/create.html.twig'
      ]);
    }

    #[Route('/ingredient/update/{id}',  methods: ['GET'])]
    public function update(?int $id): Response
    {

      $ingredient = $this->IngredientManager->read($id);

      return $this->render('container.html.twig', [
          'template' => 'ingredient/update.html.twig',
          'ingredient' => $ingredient
      ]);
    }

}
