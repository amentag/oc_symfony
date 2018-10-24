<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    const PHP = 'php';
    const SYMFONY = 'symfony';
    const CPP = 'cpp';
    const JAVA = 'java';
    const PHOTOSHOP = 'photoshop';
    const BLENDER = 'blender';
    const NOTEPAD = 'notepad';

    public function load(ObjectManager $manager)
    {
        $names = [
            self::PHP => 'PHP',
            self::SYMFONY => 'Symfony',
            self::CPP => 'C++',
            self::JAVA => 'Java',
            self::PHOTOSHOP => 'Photoshop',
            self::BLENDER => 'Blender',
            self::NOTEPAD => 'Bloc-note'
        ];

        foreach ($names as $reference => $name) {
            $skill = new Skill();
            $skill->setName($name);

            $manager->persist($skill);

            $this->addReference($reference, $skill);
        }

        $manager->flush();
    }
}
