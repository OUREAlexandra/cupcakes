<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $invoice = new Invoice();
            $invoice->setCreatedAt($faker->dateTimeBetween('now', '+1month'));
            // $invoice->setUuser($this->getReference('user_' . rand(0, 19)));
            $invoice->addCommand($this->getReference('command_' . rand(0, 49)));
            $invoice->addProduct($this->getReference('product_' . rand(0, 14)));
            $manager->persist($invoice);
            $this->addReference('invoice_' .$i, $invoice);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CommandFixtures::class];
    }
}