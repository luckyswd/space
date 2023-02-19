<?php

namespace App\Handler\User;

use App\Entity\Space;
use App\Entity\User;
use App\Factory\JsonFactory;
use App\Interface\CrudInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserHandler implements CrudInterface
{
    private string|null $email = null;
    private string|null $password = null;

    public function __construct(
        private RequestStack                $requestStack,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface      $entityManager,
        private readonly UserRepository              $userRepository,
        private readonly JWTTokenManagerInterface    $JWTManager,
        private readonly JsonFactory                 $jsonFactory,
    )
    {
    }

    public function __invoke(): array
    {
        try {
            $this->setProperties();
            $this->checkValidation();
            $user = $this->createUser();

            return [
                'status' => true,
                'token' => $this->getToken($user),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function createUser(): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $this->password);

        $user->setRoles(['ROLE_ADMIN'])
            ->setEmail($this->email)
            ->setUsername($this->email)
            ->setPassword($hashedPassword)
            ->setCreatedAt(new \DateTime())
            ->setSpace($this->createSpace());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function createSpace(): Space
    {
        $space = new Space();
        $space->setCreatedAt(new \DateTime());
        $this->entityManager->persist($space);

        return $space;
    }

    private function getToken(
        User $user,
    ): string
    {
        return $this->JWTManager->create($user);
    }

    /**
     * @throws Exception
     */
    public function checkValidation(): void
    {
        if (!$this->email || !$this->password) {
            throw new Exception('Missing credentials');
        }

        if ($this->userRepository->findOneBy(['email' => $this->email])) {
            throw new Exception('This user already exists');
        }
    }

    public function setProperties()
    {
        $this->requestStack = $this->jsonFactory->transformJsonBody($this->requestStack);
        $this->email = $this->requestStack->getMainRequest()->get('email');
        $this->password = $this->requestStack->getMainRequest()->get('password');
    }
}