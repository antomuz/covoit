<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');
        $Utilisateur1 = new Utilisateur();
        $Utilisateur1
            ->setNom("Admin")
            ->setPrenom("Admin")
            ->setEmail("admin")
            ->setTelephone('0000000000')
            ->setModeApp(0)
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$UcFg15lIqc2utrlebTh5ZQ$NKgEJkN6H5SzAcKtsTtAaMUdg+MwsU8VBnyR8kJffnM')
            ->setRoles(["ROLE_USER,ROLE_ADMIN"]);
        $manager->persist($Utilisateur1);

        $Utilisateur2 = new Utilisateur();
        $Utilisateur2
            ->setNom($faker->lastName())
            ->setPrenom($faker->firstName())
            ->setEmail($faker->safeEmail())
            ->setTelephone($faker->phoneNumber())
            ->setModeApp($faker->numberBetween(0, 1))
            ->setPassword("test")
            ->setRoles(["ROLE_USER,ROLE_ADMIN"]);
        $manager->persist($Utilisateur2);

        $Utilisateur3 = new Utilisateur();
        $Utilisateur3
            ->setNom($faker->lastName())
            ->setPrenom($faker->firstName())
            ->setEmail($faker->safeEmail())
            ->setTelephone($faker->phoneNumber())
            ->setModeApp($faker->numberBetween(0, 1))
            ->setPassword("test")
            ->setRoles(["ROLE_USER,ROLE_ADMIN"]);
        $manager->persist($Utilisateur3);

        $manager->flush();

        $this->addReference('Utilisateur1', $Utilisateur1);
        $this->addReference('Utilisateur2', $Utilisateur2);
        $this->addReference('Utilisateur3', $Utilisateur3);


    }
}