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

class IngredientAPIController extends AbstractController
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

    #[Route('/api/ingredient', name: 'ingredient', methods: ['GET', 'HEAD'])]
    public function api_readAll(): Response
    {
      $ingredients = $this->IngredientManager->readAll();
      return new JsonResponse($this->serializer->normalize($ingredients, null));
    }


    #[Route('/api/ingredient/{id}',  methods: ['GET'])]
    public function api_read(?int $id): Response
    {
      // Find the ingredient requested
      $ingredient = $this->IngredientManager->read($id);

      return new JsonResponse($this->serializer->normalize($ingredient, null));
    }


    #[Route('/api/ingredient/create', methods: ['POST'])]
    public function api_create(): JsonResponse
    {
      // Create a new ingredient using the ingredient manager
      $ingredient_id = $this->IngredientManager->create($_POST['name'], $_POST['description']);

      return new JsonResponse(array('id' => $ingredient_id));
    }


    #[Route('/api/ingredient/update', methods: ['POST'])]
    public function api_update(): JsonResponse
    {
      // Create a new ingredient using the ingredient manager
      $ingredient_id = $this->IngredientManager->update($_POST["id"], $_POST['name'], $_POST['description']);

      return new JsonResponse(array('id' => $ingredient_id));

    }


    #[Route('/api/ingredient/{id}', methods: ['DELETE'])]
    public function api_delete(): JsonResponse
    {
      return new JsonResponse(array('status' => 'Not Implemented'));
    }


}
