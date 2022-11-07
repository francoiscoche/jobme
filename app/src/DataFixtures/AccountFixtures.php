<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');


        for ($i=0; $i < 50; $i++) {
            $user = new User();

            $hashedPassword = $this->passwordHasher->hashPassword($user, "qwerty");

            $user->setEmail('user'.$i.'@test.com')
                ->setPassword($hashedPassword)
                ->setFirstname($faker->firstname())
                ->setLastname($faker->lastname())
                ->setPhone($faker->phoneNumber())
                ->setAddress($faker->address());

            $manager->persist($user);
        }


        $manager->flush();
    }
}
