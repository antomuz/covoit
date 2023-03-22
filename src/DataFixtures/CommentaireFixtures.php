<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $faker = Faker\Factory::create('fr_FR');
        $Commentaire1 = new Commentaire();
        $Commentaire1
            ->setCorps($faker->text())
            ->setIdUtilisateurAuteur($manager->merge($this->getReference('Utilisateur3')))
            ->setIdTrajetConcerner($manager->merge($this->getReference('Trajet1')));
        $manager->persist($Commentaire1);

        $manager->flush();

        $this->addReference('Commentaire1', $Commentaire1);
    }
    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
            TrajetFixtures::class,
        ];
    }
}