<?php

namespace App\DataFixtures;

use App\Entity\Texte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TexteFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $texte = new Texte();
        $texte->setTitre('Hello ! Moi c’est Marina et bienvenue sur mon book !');
        $texte->setTexte('Ici vous pouvez découvrir mes différentes compétences ainsi que mes créations par le biais de ce site web ! j’espère que cela vous plaiera =)');
        $texte->setInfo('Si jamais vous avez besoin de mes services,vous pouvez me contacter grace aux différentes informations disponible dans la rubrique Contact ! n’hésitez pas je ne mord pas promis !');

        $manager->persist($texte);
        $manager->flush();
    }
}
