<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Trajet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrajetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');
        $Trajet1 = new Trajet();
        $Trajet1
            ->setVilleDepart($faker->city())
            ->setVilleArrivee($faker->city())
            ->setDateHeure($faker->dateTimeBetween('+1 week', '+6 months'))
            ->setVoiture($faker->word())
            ->setNbPlace($faker->numberBetween(1, 4))
            ->setPrix($faker->numberBetween(15, 100))
            ->setIdUtilisateurAuteur($manager->merge($this->getReference('Utilisateur1')));
        $manager->persist($Trajet1);

        $manager->flush();


        $this->addReference('Trajet1', $Trajet1);
    }
    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
        ];
    }
}