<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    /**
     * @var SluggerInterface
     */
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Créer les tags
        for($i = 1; $i <=10; $i++){
            $tag = new Tag();
            $tag->setName($faker->creditCardType);
            $manager->persist($tag);
    }



        //on créé les users
        $users = [];
        for($i = 1; $i <= 10; $i++){
            $user = new User();
            $user->setUsername($faker->lastName);
            $manager->persist($user);
            $users[]= $user;
        }
        $categorys = [];
        for($i = 1; $i <= 5; $i++){
            $category = new Category();
            $category->setName($faker->jobTitle);
            $category->setDescription($faker->sentence(10,true));
            $category->setSlug($faker->slug(3,true));
            $manager->persist($category);
            $categorys[] = $category;
        }
        //on créé les produits
        for($i = 1; $i<=100; $i++){
            $product = new Product();
            $product->setName($faker->firstNameMale);
            $product->setDescription($faker->sentence(10,true));
            $product->setPrice($faker->randomDigitNotNull);
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setUser($users[rand(0, 9)]);
            $product->setCategory($categorys[rand(0,4)]);
            $manager->persist($product);
        }




        $manager->flush();
    }
}
