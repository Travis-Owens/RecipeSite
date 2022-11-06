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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


use App\Service\RecipeManager;

class RecipeAPIController extends AbstractController
{

    private RecipeManager $RecipeManager;
    private Serializer $serializer;

    public function __construct(RecipeManager $RecipeManager) {

      // RecipeManager is used to interact with the Recipe group entities
      $this->RecipeManager = $RecipeManager;

      // Serializer is used for the API routes; converts entities to JSON
      $encoders = [new XmlEncoder(), new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];
      $this->serializer = new Serializer($normalizers, $encoders);

    }

    #[Route('/api/recipe', name: 'recipe', methods: ['GET', 'HEAD'])]
    public function api_readAll(): Response
    {
      $recipes = $this->RecipeManager->readAll();

      // Prevent Circular Referencing; replace object with object's id
      return new JsonResponse($this->serializer->normalize($recipes, 'json', [
          'circular_reference_handler' => function ($object) {
              return $object->getId();
           }
       ]));
    }


    #[Route('/api/recipe/{id}',  methods: ['GET'])]
    public function api_read(?int $id): Response
    {
      // Find the recipe requested
      $recipe = $this->RecipeManager->read($id);

      // Prevent Circular Referencing; replace object with object's id
      return new JsonResponse($this->serializer->normalize($recipe, 'json', [
          'circular_reference_handler' => function ($object) {
              return $object->getId();
           }
       ]));
    }


    #[Route('/api/recipe/create', methods: ['POST'])]
    public function api_create(): JsonResponse
    {

      // Takes raw data from the request
      $json = file_get_contents('php://input');

      // Converts it into a PHP object
      $data = json_decode($json, true);

      // Create a new recipe using the recipe manager
      $recipe_id = $this->RecipeManager->create($data["name"], $data["description"], $data["stepGroups"]);

      return new JsonResponse(array('id' => $recipe_id));
    }


    #[Route('/api/recipe/update', methods: ['POST'])]
    public function api_update(): JsonResponse
    {
      // Takes raw data from the request
      $json = file_get_contents('php://input');

      // Converts it into a PHP object
      $data = json_decode($json, true);

      // Update the specified recipe
      $recipe_id = $this->RecipeManager->update($data["id"], $data["name"], $data["description"], $data["stepGroups"]);

      return new JsonResponse(array('id' => $recipe_id));

    }


    #[Route('/api/recipe/{id}', methods: ['DELETE'])]
    public function api_delete(): JsonResponse
    {
      return new JsonResponse(array('status' => 'Not Implemented'));
    }


}
