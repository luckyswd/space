<?php

namespace App\Handler\Record;

use App\Entity\Client;
use App\Entity\Record;
use Doctrine\ORM\EntityManagerInterface;

class RemoveRecordHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function __invoke(Record $record): array
    {
        try {
            $this->entityManager->remove($record);
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