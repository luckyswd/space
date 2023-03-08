<?php

namespace App\tests\Application;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientTest extends WebTestCase
{
    private KernelBrowser $client;
    private ClientRepository|null $clientRepository;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->clientRepository = $this->getContainer()->get(ClientRepository::class);
        BaseTest::setBearer($this->client);
    }

    public function testGetClients()
    {
        $id = $this->getClientId();

        $this->client->request(
            'GET',
            BaseTest::CLIENT_URL . "/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testNewClient()
    {
        $this->client->request(
            'POST',
            BaseTest::CLIENT_URL . '/new',
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
            json_encode([
                'spaceId' => '1',
                'firstName' => BaseTest::getRandomText(),
                'lastName' => BaseTest::getRandomText(),
                'phone' => BaseTest::getRandomText(),
                'instagram' => BaseTest::getRandomText(),
                'shortDescription' => BaseTest::getRandomText(50),
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function testGetClientsSpace()
    {
        $this->client->request(
            'GET',
            BaseTest::CLIENT_URL . '/space/1',
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testRemoveClient()
    {
        $id = $this->getClientId();

        $this->client->request(
            'DELETE',
            BaseTest::CLIENT_URL . "/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testUpdateClient()
    {
        $id = $this->getClientId();

        $this->client->request(
            'PUT',
            BaseTest::CLIENT_URL . "/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
            json_encode([
                'firstName' => BaseTest::getRandomText(),
                'lastName' => BaseTest::getRandomText(),
                'phone' => BaseTest::getRandomText(),
                'instagram' => BaseTest::getRandomText(),
                'shortDescription' => BaseTest::getRandomText(50),
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    private function getClientId(): int
    {
        $clients = $this->clientRepository->findAll();

        if ($clients) {
            return $clients[0]->getId();
        }

        return 1;
    }
}
