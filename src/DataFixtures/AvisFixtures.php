<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Avis;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AvisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //$product = new Product();
        //$manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');

        $Avis1 = new Avis();
        $Avis1
            ->setNbEtoile($faker->numberBetween(0, 5))
            ->setCorps($faker->text())
            ->setIdUtilisateurConcerner($manager->merge($this->getReference('Utilisateur1')))
            ->setIdUtilisateurAuteur($manager->merge($this->getReference('Utilisateur2')));
        $manager->persist($Avis1);


        $Avis2 = new Avis();
        $Avis2
            ->setNbEtoile($faker->numberBetween(0, 5))
            ->setCorps($faker->text())
            ->setIdUtilisateurConcerner($manager->merge($this->getReference('Utilisateur3')))
            ->setIdUtilisateurAuteur($manager->merge($this->getReference('Utilisateur1')));
        $manager->persist($Avis2);


        $Avis3 = new Avis();
        $Avis3
            ->setNbEtoile($faker->numberBetween(0, 5))
            ->setCorps($faker->text())
            ->setIdUtilisateurConcerner($manager->merge($this->getReference('Utilisateur2')))
            ->setIdUtilisateurAuteur($manager->merge($this->getReference('Utilisateur1')));
        $manager->persist($Avis3);



        $manager->flush();

        $this->addReference('Avis1', $Avis1);
        $this->addReference('Avis2', $Avis2);
        $this->addReference('Avis3', $Avis3);
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
