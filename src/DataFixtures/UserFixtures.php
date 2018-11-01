<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach (['author', 'moderator', 'admin'] as $username) {
            $manager->persist(
                (new User())
                    ->setUsername($username)
                    ->setEmail($username . '@gmail.com')
                    ->setPassword($username . 'pass')
                    ->setRoles(['ROLE_' . strtoupper($username)])
                    ->setSalt('')
            );
        }

        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $username = $faker->userName;

            $user
                ->setUsername($username)
                ->setEmail($username . '@gmail.com')
                ->setPassword($faker->password)
                ->setRoles(['ROLE_AUTHOR'])
                ->setSalt('');

            $manager->persist($user);

            $this->addReference("user_$i", $user);
        }

        $manager->flush();
    }
}
