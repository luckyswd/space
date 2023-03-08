<?php

namespace App\Handler\Space;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetAuthorizedSpaceHandler
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
    )
    {
    }

    public function __invoke()
    {
        return $this->tokenStorage->getToken()->getUser()->getSpace();
    }
}