<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Articles;

class ArticleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 1;$i<=4;$i++)
        {
            $article = new Articles();
            $article->setImage('img/article.jpg');
            $article->setAlt('article-img-'.$i);
            $article->setLien('https://www.youtube.com/watch?v=DalNXP1ZosE');
            $article->setAltLien('article-'.$i.'-lien');

            $manager->persist($article);
        }

        $manager->flush();
    }
}
