<?php

namespace App\tests\Application;

use App\Repository\SpaceRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SpaceTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        BaseTest::setBearer($this->client);
    }

    public function testGetSpaces()
    {
        $this->client->request(
            'GET',
            BaseTest::SPACE_URL,
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testGetSpaceById()
    {
        $spaceRepository = $this->client->getContainer()->get(SpaceRepository::class);
        $spaces = $spaceRepository->findAll();
        $id = $spaces ? $spaces[0]->getId() : 1;

        $this->client->request(
            'GET',
            BaseTest::SPACE_URL . "/$id",
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }

    public function testGetAuthorizedSpace()
    {
        $this->client->request(
            'GET',
            BaseTest::SPACE_URL . '/authorized/space',
            [],
            [],
            ['CONTENT_TYPE' => BaseTest::CONTENT_TYPE],
        );

        $this->assertResponseIsSuccessful();
    }
}
