<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CompetenceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1;$i <= 6;$i++)
        {
            $competence = new Competence();
            $competence->setColor($faker->hexcolor);
            $competence->setImage('img/brush.png');
            $competence->setAlt('image-competence-'.$i);
            $competence->setNom($faker->sentence(1,true));
            $manager->persist($competence);
        }

        $manager->flush();
    }
}
