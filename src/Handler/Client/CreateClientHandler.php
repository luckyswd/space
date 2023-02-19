<?php

namespace App\Handler\Client;

use App\Entity\Client;
use App\Factory\JsonFactory;
use App\Interface\CrudInterface;
use App\Repository\SpaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;

class CreateClientHandler implements CrudInterface
{
    private string|null $spaceId = null;
    private string|null $firstName = null;
    private string|null $lastName = null;
    private string|null $shortDescription = null;
    private string|null $phone = null;
    private string|null $instagram = null;

    public function __construct(
        private RequestStack           $requestStack,
        private readonly EntityManagerInterface $entityManager,
        private readonly SpaceRepository        $spaceRepository,
        private readonly JsonFactory            $jsonFactory,
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
        $this->spaceId = $this->requestStack->getMainRequest()->get('spaceId');
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

        if (!$this->spaceId) {
            throw new Exception('Space cannot be empty');
        }
    }

    public function createClient(): void
    {
        $client = new Client();
        $client
            ->setSpace($this->spaceRepository->findOneBy(['id' => $this->spaceId]))
            ->setFirstName($this->firstName ?? '')
            ->setLastName($this->lastName ?? '')
            ->setShortDescription($this->shortDescription ?? '')
            ->setPhone($this->phone ?? '')
            ->setInstagram($this->instagram ?? '')
            ->setCreatedAt(new \DateTime());

        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}