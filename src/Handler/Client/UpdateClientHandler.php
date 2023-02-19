<?php

namespace App\Handler\Client;

use App\Entity\Client;
use App\Factory\JsonFactory;
use App\Interface\CrudInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;

class UpdateClientHandler implements CrudInterface
{
    private Client|null $client = null;
    private string|null $firstName = null;
    private string|null $lastName = null;
    private string|null $shortDescription = null;
    private string|null $phone = null;
    private string|null $instagram = null;

    public function __construct(
        private RequestStack           $requestStack,
        private readonly EntityManagerInterface $entityManager,
        private readonly JsonFactory            $jsonFactory,
    )
    {
    }

    public function __invoke(Client $client): array
    {
        try {
            $this->client = $client;
            $this->setProperties();
            $this->checkValidation();
            $this->updateClient();

            return [
                'status' => true,
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }

    }

    public function setProperties(): void
    {
        $this->requestStack = $this->jsonFactory->transformJsonBody($this->requestStack);
        $this->firstName = $this->requestStack->getMainRequest()->get('firstName');
        $this->lastName = $this->requestStack->getMainRequest()->get('lastName');
        $this->shortDescription = $this->requestStack->getMainRequest()->get('shortDescription');
        $this->phone = $this->requestStack->getMainRequest()->get('phone');
        $this->instagram = $this->requestStack->getMainRequest()->get('instagram');
    }

    /**
     * @throws Exception
     */
    public function checkValidation(): void
    {
        if (!$this->firstName) {
            throw new Exception('Name cannot be empty');
        }
    }

    public function updateClient(): void
    {
        $this->client
            ->setFirstName($this->firstName ?? '')
            ->setLastName($this->lastName ?? '')
            ->setShortDescription($this->shortDescription ?? '')
            ->setPhone($this->phone ?? '')
            ->setInstagram($this->instagram ?? '');
        $this->entityManager->flush();
    }
}