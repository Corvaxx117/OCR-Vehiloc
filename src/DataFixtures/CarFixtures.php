<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'name' => 'Citadine Eco',
                'description' => "Parfaite pour la ville avec une faible consommation et un stationnement aisé.",
                'monthlyPrice' => 39900,   // 399,00 €
                'dailyPrice' => 1999,      // 19,99 €
                'places' => 4,
                'motor' => 'Essence'
            ],
            [
                'name' => 'Sedan Confort',
                'description' => "Berline spacieuse offrant confort et sécurité pour les longs trajets.",
                'monthlyPrice' => 65000,   // 650,00 €
                'dailyPrice' => 3599,      // 35,99 €
                'places' => 5,
                'motor' => 'Diesel'
            ],
            [
                'name' => 'SUV Family',
                'description' => "SUV familial avec grand coffre et technologies embarquées.",
                'monthlyPrice' => 90000,   // 900,00 €
                'dailyPrice' => 3914,      // 39,14 €
                'places' => 7,
                'motor' => 'Hybride'
            ],
            [
                'name' => 'Compact Hybrid',
                'description' => "Compacte hybride combinant économie de carburant et agilité.",
                'monthlyPrice' => 72000,   // 720,00 €
                'dailyPrice' => 3299,      // 32,99 €
                'places' => 5,
                'motor' => 'Hybride'
            ],
            [
                'name' => 'Utilitaire Pro',
                'description' => "Fourgon utilitaire idéal pour transport de matériel et livraisons.",
                'monthlyPrice' => 80000,   // 800,00 €
                'dailyPrice' => 4499,      // 44,99 €
                'places' => 3,
                'motor' => 'Diesel'
            ],
            [
                'name' => 'Cabriolet Sunset',
                'description' => "Cabriolet élégant pour profiter des beaux jours en toute liberté.",
                'monthlyPrice' => 110000,  // 1 100,00 €
                'dailyPrice' => 5599,      // 55,99 €
                'places' => 4,
                'motor' => 'Essence'
            ],
        ];

        foreach ($data as $row) {
            $car = new Car();
            $car->setName($row['name']);
            $car->setDescription($row['description']);
            $car->setMonthlyPrice($row['monthlyPrice']);
            $car->setDailyPrice($row['dailyPrice']);
            $car->setPlaces($row['places']);
            $car->setMotor($row['motor']);
            $manager->persist($car);
        }

        $manager->flush();
    }
}
