<?php

namespace App\Handler\Record;

use App\Entity\Client;
use App\Entity\Record;
use App\Factory\JsonFactory;
use App\Interface\CrudInterface;
use App\Repository\ClientRepository;
use App\Repository\SpaceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;

class CreateRecordHandler implements CrudInterface
{
    private string|null $clientId = null;
    private string|null $startDate = null;
    private int|null $price = null;

    public function __construct(
        private RequestStack                    $requestStack,
        private readonly EntityManagerInterface $entityManager,
        private readonly JsonFactory            $jsonFactory,
        private readonly ClientRepository       $clientRepository,
    )
    {
    }

    public function __invoke(): array
    {
        try {
            $this->setProperties();
            $this->checkValidation();
            $this->createClient();

            return [
                'status' => true,
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function setProperties(): void
    {
        $this->requestStack = $this->jsonFactory->transformJsonBody($this->requestStack);
        $this->clientId = $this->requestStack->getMainRequest()->get('clientId');
        $this->startDate = $this->requestStack->getMainRequest()->get('startDate');
        $this->price = $this->requestStack->getMainRequest()->get('price');
    }

    /**
     * @throws Exception
     */
    public function checkValidation(): void
    {
        if (!DateTime::createFromFormat(Record::DATE_FORMAT, $this->startDate)) {
            throw new Exception('Invalid date format. Must be d-m-Y H:i:s(30-10-2023 10:10:10)');
        }

        if (!$this->clientId) {
            throw new Exception('ClientId cannot be empty');
        }
    }

    public function createClient(): void
    {
        $record = new Record();
        $record
            ->setCreatedAt(new DateTime())
            ->setClient($this->clientRepository->findOneBy(['id' => $this->clientId]))
            ->setStartDate(DateTime::createFromFormat(Record::DATE_FORMAT, $this->startDate))
            ->setPrice($this->price);

        $this->entityManager->persist($record);
        $this->entityManager->flush();
    }
}