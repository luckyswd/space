<?php

namespace App\tests\Application;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        BaseTest::setBearer($this->client);
    }

    public function testGetUsers()
    {
        $this->client->request(
            'GET',
            "/api/users",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testNewUser()
    {
        $this->client->request(
            'POST',
            '/api/user/new',
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
            json_encode([
                'email' => BaseTest::getRandomEmail(),
                'password' => BaseTest::getRandomText(),
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function testGetUserById()
    {
        $userRepository = $this->client->getContainer()->get(UserRepository::class);
        $users = $userRepository->findAll();
        $id = $users ? $users[0]->getId() : 1;

        $this->client->request(
            'GET',
            "/api/user/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
            json_encode([
                'email' => BaseTest::getRandomEmail(),
                'password' => BaseTest::getRandomText(),
            ])
        );

        $this->assertResponseIsSuccessful();
    }
}
