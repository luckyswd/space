<?php

namespace App\tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CheckApiDocTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET',  'http://space.loc/api/doc');

        $this->assertResponseIsSuccessful();
    }
}
