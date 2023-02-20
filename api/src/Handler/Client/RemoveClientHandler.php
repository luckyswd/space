<?php

namespace App\Handler\Client;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

class RemoveClientHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function __invoke(Client $client): array
    {
        try {
            $this->entityManager->remove($client);
            $this->entityManager->flush();

            return [
                'status' => true,
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'ooops...',
            ];
        }
    }
}