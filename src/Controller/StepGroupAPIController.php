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

use App\Service\StepGroupManager;

class StepGroupAPIController extends AbstractController
{

    private StepGroupManager $StepGroupManager;
    private Serializer $serializer;

    public function __construct(StepGroupManager $StepGroupManager) {

      // StepGroupManager is used to interact with the step group entities
      $this->StepGroupManager = $StepGroupManager;

      // Serializer is used for the API routes; converts entities to JSON
      $encoders = [new XmlEncoder(), new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];
      $this->serializer = new Serializer($normalizers, $encoders);

    }

    #[Route('/api/stepgroup', name: 'step', methods: ['GET', 'HEAD'])]
    public function api_readAll(): Response
    {
      $stepGroups = $this->StepGroupManager->readAll();
      return new JsonResponse($this->serializer->normalize($stepGroups, null));
    }


    #[Route('/api/stepgroup/{id}',  methods: ['GET'])]
    public function api_read(?int $id): Response
    {
      // Find the step requested
      $stepGroup = $this->StepGroupManager->read($id);

      return new JsonResponse($this->serializer->normalize($stepGroup, null));
    }


    #[Route('/api/stepgroup/create', methods: ['POST'])]
    public function api_create(): JsonResponse
    {

      // Takes raw data from the request
      $json = file_get_contents('php://input');

      // Converts it into a PHP object
      $data = json_decode($json, true);

      // Create a new step using the step manager
      $stepGroup_id = $this->StepGroupManager->create($data["name"], $data["description"]);

      return new JsonResponse(array('id' => $stepGroup_id));
    }


    #[Route('/api/stepgroup/update', methods: ['POST'])]
    public function api_update(): JsonResponse
    {
      // Takes raw data from the request
      $json = file_get_contents('php://input');

      // Converts it into a PHP object
      $data = json_decode($json, true);


      // Create a new step using the step manager
      $stepGroup_id = $this->StepGroupManager->update($data["id"], $data["name"], $data["description"]);

      return new JsonResponse(array('id' => $stepGroup_id));

    }


    #[Route('/api/stepgroup/{id}', methods: ['DELETE'])]
    public function api_delete(): JsonResponse
    {
      return new JsonResponse(array('status' => 'Not Implemented'));
    }


}
