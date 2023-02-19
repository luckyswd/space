<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Record;
use App\Entity\Space;
use App\Entity\User;
use App\Repository\SpaceRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    public function load(ObjectManager $manager)
    {
        $spaces = [];
        for ($i = 0; $i < 3; $i++) {
            $space = new Space();
            $space->setCreatedAt(new DateTime());
            $spaces[] = $space;
            $manager->persist($space);

            $user = new User();
            $user->setSpace($space);
            $user->setEmail("test-$i@gmail.com");
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'test');
            $user->setPassword($hashedPassword);
            $user->setUsername("test-$i@gmail.com");
            $user->setRoles(['ROLE_ADMIN']);
            $user->setCreatedAt(new DateTime());

            $manager->persist($user);
        }

        $clients = [];
        for ($i = 0; $i < 40; $i++) {
            $client = new Client();
            $client->setCreatedAt(new DateTime());
            $client->setFirstName("first name-$i");
            $client->setLastName("last name-$i");
            $client->setPhone("+375-29-111-11-$i");
            $client->setInstagram("instagram-$i");
            $client->setShortDescription("text-$i");
            $clients[] = $client;
            $key = array_rand($spaces);
            $client->setSpace($spaces[$key]);

            $manager->persist($client);
        }

        for ($i = 0; $i < 40; $i++) {
            $record = new Record();
            $record->setCreatedAt(new DateTime());
            $record->setStartDate(new DateTime());
            $record->setPrice($i);
            $key = array_rand($clients);
            $record->setClient($clients[$key]);

            $manager->persist($record);
        }

        $manager->flush();
    }
}