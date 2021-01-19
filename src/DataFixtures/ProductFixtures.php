<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const PRODUCTS = [
        'Le céréaliers',
        'Le m\'as-tu vu',
        'Le mi-choco chantilly',
        'Le câlin hivernale',
        'Le spécial Pâques',
        'Le bicolore',
        'Le nuit étoilée',
        'Le bunny',
        'Le nuage d\'amour',
        'Le poirier coulant caramel',
        'Le chocolat tic et tac',
        'Le spécial Valentin',
        'Le tout choco',
        'Le spécial célébration',
        'Le coeur de guimauve'
    ];
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        foreach (self::PRODUCTS as $key => $productName) {
            $product = new Product();
            $product->setName($productName);
            $product->setQuantity($faker->numberBetween(10, 500));
            $product->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 2, $max = 5.5));
            $product->setDescription($faker->text($maxNbChars = 200));
            $product->setIsActivated((bool)rand(0, 1));
            $product->setImage('https://blog.feeriecake.fr/wp-content/uploads/2020/02/cupcake-chocolat-lindor-2.jpg');
            $product->setCategory($this->getReference('category_' . rand(0,4)));
            $manager->persist($product);
            $this->addReference('product_' .$key, $product);
        }

        $manager->flush();
    }

    public function getDependencies()  
    {
        return [CategoryFixtures::class];  
    }

}