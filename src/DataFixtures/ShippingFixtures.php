<?php

namespace App\DataFixtures;

use App\Entity\Shipping;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ShippingFixtures extends Fixture implements DependentFixtureInterface
{
    public const SHIPPINGS = [
        'Uber eats' => [
            'cost' => 5.95
        ],
        'Deliveroo' => [
            'cost' => 5.95
        ],
        'Retrait en point de vente' => [
            'cost' => 3.95
        ]
    ];
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        foreach (self::SHIPPINGS as $type => $data) {
            $shipping = new Shipping();
            $shipping->setType($type);
            $shipping->setCost($data['cost']);
            $shipping->addCommand($this->getReference('command_' . rand(0,49)));
            $manager->persist($shipping);
            $this->addReference('shipping_' .$type, $shipping);
        }

        $manager->flush();
    }

    public function getDependencies()  
    {
        return [CommandFixtures::class];  
    }

}