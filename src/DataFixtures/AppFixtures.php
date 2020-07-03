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
                    $post->setText('"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"');
                    $post->setCategory($category);
                    $manager->persist($post);
                }

            }

        }
        $manager->flush();

    }
}
