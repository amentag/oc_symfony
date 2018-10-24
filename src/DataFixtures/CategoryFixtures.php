<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    const WEB_DEVELOPER = 'web-developer';
    const MOBILE_DEVELOPER = 'mobile-developer';
    const DESIGNER = 'designer';
    const FRONT_DEVELOPER = 'front-developer';
    const NETWORK = 'network';

    public function load(ObjectManager $manager)
    {

        // Liste des noms de catégorie à ajouter
        $names = array(
            self::WEB_DEVELOPER => 'Développement web',
            self::MOBILE_DEVELOPER => 'Développement mobile',
            self::DESIGNER => 'Graphisme',
            self::FRONT_DEVELOPER => 'Intégration',
            self::NETWORK => 'Réseau'
        );

        foreach ($names as $reference => $name) {
            // On crée la catégorie
            $category = new Category();
            $category->setName($name);

            // On la persiste
            $manager->persist($category);
            $this->addReference($reference, $category);
        }


        $manager->flush();
    }
}
