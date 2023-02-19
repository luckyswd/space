<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\JsonFactory;
use App\Handler\User\CreateUserHandler;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class UserController extends AbstractController
{
    #[Route('/users', methods: ['GET'])]
    #[OA\Tag(name: "User")]
    #[OA\Response(
        response: 200,
        description: 'Get the users list',
    )]
    public function all(
        UserRepository $userRepository,
        JsonFactory    $jsonResponseFactory,
    ): Response
    {
        return $jsonResponseFactory->createResponseJson($userRepository->findAll());
    }

    #[Route('/user/new', methods: ['POST'])]
    #[OA\Tag(name: "User")]
    #[OA\Response(
        response: 200,
        description: 'Create new user',
    )]
    #[OA\RequestBody(
        content: [new OA\MediaType(mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "email", type: "string"),
                    new OA\Property(property: "password", type: "string"),
                ]
            )
        )],
    )]
    public function new(
        CreateUserHandler $createUserHandler,
    ): JsonResponse
    {
        return $this->json($createUserHandler());
    }

    #[Route('/user/{id}', methods: ['GET'])]
    #[OA\Tag(name: "User")]
    #[OA\Response(
        response: 200,
        description: 'Get the user by id',
    )]
    public function getById(
        User        $user,
        JsonFactory $jsonResponseFactory,
    ): Response
    {
        return $jsonResponseFactory->createResponseJson($user);
    }
}