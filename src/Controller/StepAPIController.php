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

use App\Service\StepManager;

class StepAPIController extends AbstractController
{

    private StepManager $StepManager;
    private Serializer $serializer;

    public function __construct(StepManager $StepManager) {

      // StepManager is used to interact with the step entities
      $this->StepManager = $StepManager;

      // Serializer is used for the API routes; converts entities to JSON
      $encoders = [new XmlEncoder(), new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];
      $this->serializer = new Serializer($normalizers, $encoders);

    }

    #[Route('/api/step', name: 'step', methods: ['GET', 'HEAD'])]
    public function api_readAll(): Response
    {
      $steps = $this->StepManager->readAll();
      return new JsonResponse($this->serializer->normalize($steps, null));
    }


    #[Route('/api/step/{id}',  methods: ['GET'])]
    public function api_read(?int $id): Response
    {
      // Find the step requested
      $step = $this->StepManager->read($id);

      return new JsonResponse($this->serializer->normalize($step, null));
    }


    #[Route('/api/step/create', methods: ['POST'])]
    public function api_create(): JsonResponse
    {

      // Takes raw data from the request
      $json = file_get_contents('php://input');

      // Converts it into a PHP object
      $data = json_decode($json, true);

      // Create a new step using the step manager
      $step_id = $this->StepManager->create($data['step_group_id'], $data['title'], $data['description'], $data['ingredient_id']);

      return new JsonResponse(array('id' => $step_id));
    }


    #[Route('/api/step/update', methods: ['POST'])]
    public function api_update(): JsonResponse
    {
      // Takes raw data from the request
      $json = file_get_contents('php://input');

      // Converts it into a PHP object
      $data = json_decode($json, true);


      // Create a new step using the step manager
      $step_id = $this->StepManager->update($data['id'], $data['step_group_id'], $data['title'], $data['description'], $data['ingredient_id']);

      return new JsonResponse(array('id' => $step_id));

    }


    #[Route('/api/step/{id}', methods: ['DELETE'])]
    public function api_delete(): JsonResponse
    {
      return new JsonResponse(array('status' => 'Not Implemented'));
    }


}
