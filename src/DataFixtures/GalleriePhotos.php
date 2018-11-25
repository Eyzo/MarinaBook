<?php

namespace App\DataFixtures;

use App\Entity\GalleriePhoto;
use App\Entity\Photos;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GalleriePhotos extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        for($i=1;$i<=5;$i++)
        {
            $gallerie = new GalleriePhoto();
            $gallerie->setNom($faker->name);
            $gallerie->setImage('img/realisation-exemple.jpg');
            $gallerie->setAlt('realisation-img-'.$i);
            $gallerie->setDescription($faker->paragraph(1,true));

            for ($j=1;$j<=mt_rand(4,7);$j++)
            {
                $photo = new Photos();
                $photo->setImage('img/article.jpg');
                $photo->setAlt('photo-'.$i);
                $photo->setGalleriePhoto($gallerie);

                $manager->persist($photo);
            }

            $manager->persist($gallerie);
        }

        $manager->flush();
    }
}
