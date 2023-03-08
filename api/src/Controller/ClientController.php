<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Space;
use App\Factory\JsonFactory;
use App\Handler\Client\UpdateClientHandler;
use App\Handler\Client\CreateClientHandler;
use App\Handler\Client\RemoveClientHandler;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/clients')]
class ClientController extends AbstractController
{
    #[Route('/new', methods: ['POST'])]
    #[OA\Tag(name: "Client")]
    #[OA\Response(
        response: 200,
        description: 'Create new Client',
    )]
    #[OA\RequestBody(
        content: [new OA\MediaType(mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "spaceId", type: "integer"),
                    new OA\Property(property: "firstName", type: "string"),
                    new OA\Property(property: "lastName", type: "string"),
                    new OA\Property(property: "phone", type: "string"),
                    new OA\Property(property: "instagram", type: "string"),
                    new OA\Property(property: "shortDescription", type: "string"),
                ]
            )
        )],
    )]
    public function create(
        CreateClientHandler $createClientHandler,
    ): JsonResponse
    {
        return $this->json($createClientHandler());
    }

    #[Route('/{id}', methods: ['GET'])]
    #[OA\Tag(name: "Client")]
    #[OA\Response(
        response: 200,
        description: 'Get the client by id',
    )]
    public function getClientById(
        Client           $client,
        JsonFactory      $jsonResponseFactory,
    ): Response
    {
        return $jsonResponseFactory->createResponseJson($client);
    }

    #[Route('/space/{id}', methods: ['GET'])]
    #[OA\Tag(name: "Client")]
    #[OA\Response(
        response: 200,
        description: 'Get the clients list for space',
    )]
    public function all(
        Space            $space,
        ClientRepository $clientRepository,
        JsonFactory      $jsonResponseFactory,
    ): Response
    {
        return $jsonResponseFactory->createResponseJson($clientRepository->findBy(['space' => $space]));
    }

    #[Route('/{id}', methods: ['DELETE'])]
    #[OA\Tag(name: "Client")]
    #[OA\Response(
        response: 200,
        description: 'Remove Client',
    )]
    public function remove(
        Client              $client,
        RemoveClientHandler $removeClientHandler
    ): JsonResponse
    {
        return $this->json($removeClientHandler($client));
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[OA\Tag(name: "Client")]
    #[OA\Response(
        response: 200,
        description: 'Update Client',
    )]
    #[OA\RequestBody(
        content: [new OA\MediaType(mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "firstName", type: "string"),
                    new OA\Property(property: "lastName", type: "string"),
                    new OA\Property(property: "phone", type: "string"),
                    new OA\Property(property: "instagram", type: "string"),
                    new OA\Property(property: "shortDescription", type: "string"),
                ]
            )
        )],
    )]
    public function update(
        Client              $client,
        UpdateClientHandler $updateClientHandler,
    ): JsonResponse
    {
        return $this->json($updateClientHandler($client));
    }
}