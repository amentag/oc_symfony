<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\ValueObject\Point;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $location = new Location();
        $location->setName('maroc')->setCoordinates(new Point(31, -8));

        $manager->persist($location);

        $manager->flush();
    }
}
