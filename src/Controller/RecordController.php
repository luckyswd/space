<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Record;
use App\Entity\Space;
use App\Handler\Client\RemoveClientHandler;
use App\Handler\Record\CreateRecordHandler;
use App\Handler\Record\RemoveRecordHandler;
use App\Handler\Record\UpdateRecordHandler;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api')]
class RecordController extends AbstractController
{
    #[Route('/record/new', methods: ['POST'])]
    #[OA\Tag(name: "Record")]
    #[OA\Response(
        response: 200,
        description: 'Create new record',
    )]
    #[OA\RequestBody(
        content: [new OA\MediaType(mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "clientId", type: "integer"),
                    new OA\Property(property: "startDate", type: "string"),
                    new OA\Property(property: "price", type: "integer"),
                ]
            )
        )],
    )]
    public function create(
        CreateRecordHandler $createRecordHandler,
    ): JsonResponse
    {
        return $this->json($createRecordHandler());
    }

    #[Route('/records', methods: ['GET'])]
    #[OA\Tag(name: "Record")]
    #[OA\Response(
        response: 200,
        description: 'Get all records',
    )]
    public function getAllRecords(
        RecordRepository $recordRepository,
    ): JsonResponse
    {
        return $this->json($recordRepository->findAll());
    }

    #[Route('/record/{id}', methods: ['GET'])]
    #[OA\Tag(name: "Record")]
    #[OA\Response(
        response: 200,
        description: 'Get record by id',
    )]
    public function getRecordById(
        Record $record,
        RecordRepository $recordRepository,
    ): JsonResponse
    {
        return $this->json($recordRepository->findOneBy(['id' => $record]));
    }

    #[Route('/records/client/{id}', methods: ['GET'])]
    #[OA\Tag(name: "Record")]
    #[OA\Response(
        response: 200,
        description: 'Get records by client',
    )]
    public function getRecordsByClient(
        Client           $client,
        RecordRepository $recordRepository,
    ): JsonResponse
    {
        return $this->json($recordRepository->findBy(['client' => $client]));
    }

    #[Route('/records/space/{id}', methods: ['GET'])]
    #[OA\Tag(name: "Record")]
    #[OA\Response(
        response: 200,
        description: 'Get records by Space',
    )]
    public function getRecordsBySpace(
        Space            $space,
        RecordRepository $recordRepository,
    ): JsonResponse
    {
        return $this->json($recordRepository->getRecordsBySpace($space));
    }

    #[Route('/record/remove/{id}', methods: ['DELETE'])]
    #[OA\Tag(name: "Record")]
    #[OA\Response(
        response: 200,
        description: 'Remove record',
    )]
    public function remove(
        Record              $record,
        RemoveRecordHandler $removeRecordHandler,
    ): JsonResponse
    {
        return $this->json($removeRecordHandler($record));
    }

    #[Route('/record/update/{id}', methods: ['PUT'])]
    #[OA\Tag(name: "Record")]
    #[OA\Response(
        response: 200,
        description: 'Update record',
    )]
    #[OA\RequestBody(
        content: [new OA\MediaType(mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "startDate", type: "string"),
                    new OA\Property(property: "price", type: "integer"),
                ]
            )
        )],
    )]
    public function update(
        Record $record,
        UpdateRecordHandler $recordHandler,
    ): JsonResponse
    {
        return $this->json($recordHandler($record));
    }
}