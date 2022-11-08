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

        $faker = Factory::create('it_IT');


        for ($i=0; $i < 50; $i++) {
            $user = new User();

            $hashedPassword = $this->passwordHasher->hashPassword($user, "qwerty");

            $user->setEmail('user'.$i.'@test.com')
                ->setPassword($hashedPassword)
                ->setFirstname($faker->firstname())
                ->setLastname($faker->lastname())
                ->setPhone($faker->phoneNumber())
                ->setAddress($faker->streetAddress())
                ->setPostCode($faker->postcode())
                ->setCity($faker->city())
                ->setPresentation($faker->realText(100));

            $manager->persist($user);
        }


        $manager->flush();
    }
}
