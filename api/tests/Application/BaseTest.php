<?php

namespace App\tests\Application;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\String\ByteString;

class BaseTest
{
    const CONTENT_TYPE = 'application/json';
    const USER_URL = '/api/users';
    const CLIENT_URL = '/api/clients';
    const RECORDS_URL = '/api/records';

    public static function setBearer(
        KernelBrowser $client,
    ): void
    {
        $client->request(
            'GET',
            self::USER_URL . '/login',
            [],
            [],
            ['CONTENT_TYPE' => self::CONTENT_TYPE],
            json_encode([
                'username' => 'test-0@gmail.com',
                'password' => 'test',
            ])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
    }

    public static function getRandomText(
        int $length = 10,
    ): string
    {
        return ByteString::fromRandom($length, implode('', range('A', 'Z')))->toString();
    }

    public static function getRandomEmail(): string
    {
        $text = self::getRandomText(8);

        return "$text@gmail.com";
    }

    public static function getRandomNumber(): int
    {
        return rand(0, 100000);
    }

    public static function getRandomDate(): string
    {
        $int = rand(1262055681, 1262055681);

        return date("d-m-Y H:i:s", $int);
    }
}