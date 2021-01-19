<?php

namespace App\DataFixtures;

use App\Entity\Command;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class CommandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $command = new Command();
            $command->setTotal($faker->randomFloat($nbMaxDecimals = 2, $min = 13.95, $max = 5000));
            $command->setCreatedAt($faker->dateTimeBetween('now'));
            $command->setUuser($this->getReference('user_' . rand(1, 19)));
            $command->addProduct($this->getReference('product_' . rand(0, 14)));
            // $command->setInvoice($this->getReference('invoice_' . rand(0, 49)));
            // $command->setShipping($this->getReference('shipping_' . rand(0, 2)));
            $manager->persist($command);
            $this->addReference('command_' .$i, $command);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProductFixtures::class];
    }
    
}