<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\AdvertSkill;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Skill;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AdvertFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $faker = Factory::create();

        for ($i = 1; $i <= 15; $i++) {
            $advert = new Advert();
            $advert
                ->setAuthor($this->getUser('user_' . rand(1, 5)))
                ->setImage((new Image())->setAlt('')->setUrl('https://picsum.photos/130/100?image=' . rand(1, 1000)))
                ->setContent($faker->text)
                ->setTitle($faker->sentence);

            foreach ($this->getCategories() as $category) {
                $advert->addCategory($category);
            }

            foreach ($this->getSkills() as $skill) {
                $advert->addAdvertSkill((new AdvertSkill())
                    ->setAdvert($advert)
                    ->setSkill($skill)
                    ->setLevel(rand(1, 5))
                );
            }

            $manager->persist($advert);
        }

        $manager->flush();
    }

    /**
     * @return object|User
     */
    private function getUser(string $reference)
    {
        return $this->getReference($reference);
    }

    /**
     * @return \Generator|Category
     */
    private function getCategories(): \Generator
    {
        $limit = rand(1, 5);

        $labels = [
            CategoryFixtures::DESIGNER,
            CategoryFixtures::FRONT_DEVELOPER,
            CategoryFixtures::NETWORK,
            CategoryFixtures::MOBILE_DEVELOPER,
            CategoryFixtures::WEB_DEVELOPER
        ];

        shuffle($labels);

        for ($i = 1; $i <= $limit; $i++) {
            yield $this->getReference(array_pop($labels));
        }
    }

    /**
     * @return \Generator|Skill
     */
    private function getSkills(): \Generator
    {
        $limit = rand(1, 5);

        $labels = [
            SkillFixtures::PHP,
            SkillFixtures::SYMFONY,
            SkillFixtures::CPP,
            SkillFixtures::JAVA,
            SkillFixtures::PHOTOSHOP,
            SkillFixtures::BLENDER,
            SkillFixtures::NOTEPAD
        ];

        shuffle($labels);

        for ($i = 1; $i <= $limit; $i++) {
            yield $this->getReference(array_pop($labels));
        }
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            SkillFixtures::class,
        ];
    }
}
