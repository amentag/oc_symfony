<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\ValueObject\Currency;
use App\ValueObject\Money;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $product = new Product();
         $product->setName('thon à l\'huile')->setPrice(new Money(1.89, new Currency('eur')));

         $manager->persist($product);

        $manager->flush();
    }
}
