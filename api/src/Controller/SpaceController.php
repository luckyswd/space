<?php

namespace App\Controller;

use App\Entity\Space;
use App\Handler\Space\GetAuthorizedSpaceHandler;
use App\Repository\SpaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/spaces')]
class SpaceController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    #[OA\Tag(name: "Space")]
    #[OA\Response(
        response: 200,
        description: 'Get all spaces',
    )]
    public function getSpaces(
        SpaceRepository $spaceRepository,
    ): JsonResponse
    {
        return $this->json($spaceRepository->findAll());
    }

    #[Route('/{id}', methods: ['GET'])]
    #[OA\Tag(name: "Space")]
    #[OA\Response(
        response: 200,
        description: 'Get space by id',
    )]
    public function getSpaceById(
        Space $space,
        SpaceRepository $spaceRepository,
    ): JsonResponse
    {
        return $this->json($spaceRepository->findOneBy(['id' => $space]));
    }

    #[Route('/authorized/space', methods: ['GET'])]
    #[OA\Tag(name: "Space")]
    #[OA\Response(
        response: 200,
        description: 'Get authorized space',
    )]
    public function getAuthorizedSpace(
        GetAuthorizedSpaceHandler $authorizedSpaceHandler,
    ): JsonResponse
    {
        return $this->json($authorizedSpaceHandler());
    }
}