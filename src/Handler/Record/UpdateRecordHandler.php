<?php

namespace App\Handler\Record;

use App\Entity\Record;
use App\Factory\JsonFactory;
use App\Interface\CrudInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;

class UpdateRecordHandler implements CrudInterface
{
    private Record|null $record = null;
    private string|null $startDate = null;
    private int|null $price = null;

    public function __construct(
        private RequestStack                    $requestStack,
        private readonly EntityManagerInterface $entityManager,
        private readonly JsonFactory            $jsonFactory,
    )
    {
    }

    public function __invoke(Record $record): array
    {
        try {
            $this->record = $record;
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
    }

    public function createClient(): void
    {
        $this->record
            ->setStartDate(DateTime::createFromFormat(Record::DATE_FORMAT, $this->startDate))
            ->setPrice($this->price);

        $this->entityManager->flush();
    }
}