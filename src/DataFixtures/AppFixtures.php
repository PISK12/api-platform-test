<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Magazine;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $magazine = new Magazine();
            $magazine->setName(sprintf('%d. magazine', $i));
            $manager->persist($magazine);
            for ($k = 0; $k < 10; $k++) {
                $category= new Category();
                $category->setName(sprintf('%d. category for %d. magazine', $k,$i));
                $category->setMagazine($magazine);
                $manager->persist($category);
                for ($z = 0; $z < 30; $z++) {
                    $post = new Post();
                    $post->setTitle(sprintf('%d. post for %d. category for %d. magazine',$z, $k, $i));
					$post->setText(' Sed dictum ornare sollicitudin. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec quis consectetur nunc, ac pulvinar dui. Maecenas nibh dui, fermentum eget sollicitudin non, elementum sed orci. Phasellus accumsan, justo non porta malesuada, lorem purus porta ante, sed pharetra mauris turpis sit amet urna. Ut commodo sollicitudin imperdiet. Morbi at consequat purus, vitae tempus orci. Integer vehicula quam magna, ac convallis lacus placerat in. Phasellus fringilla posuere ultricies. Phasellus consectetur non turpis ut ornare. Nullam mattis dui id sollicitudin elementum. Phasellus ex est, dictum non arcu ac, tempus consectetur purus. Vivamus dolor leo, sollicitudin id ultricies ac, dapibus ac turpis. ');
                    $post->setCategory($category);
                    $manager->persist($post);
                }

            }

        }
        $manager->flush();

    }
}
