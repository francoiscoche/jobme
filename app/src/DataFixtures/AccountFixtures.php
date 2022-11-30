<?php

namespace App\DataFixtures;

use App\Entity\Category;
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

        $categories = ["Bricolage", "Giardinaggio", "Trasloco", "Servizio di babysitter", "Animali", "Informatica", "Lezioni private", "Aiuto domestico", "Lavori di casa"];
        $img = [
            '/images/homepage/bricolage.svg',
            '/images/homepage/jardinage.svg',
            '/images/homepage/demenagement.svg',
            '/images/homepage/enfants.svg',
            '/images/homepage/chiens.svg',
            '/images/homepage/informatic.svg',
            '/images/homepage/lezioni.svg',
            '/images/homepage/courses.svg',
            '/images/homepage/maisons.svg',
        ];

        // Category
        for ($i=0; $i < count($categories); $i++) { 
            $category = new Category();

            $category->setName($categories[$i])
                    ->setImage($img[$i]);
            $manager->persist($category);
        }


        // User
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
                ->setRoles(['ROLE_JOBBER'])
                ->setPresentation($faker->realText(100));

            $manager->persist($user);
        }


        $manager->flush();
    }
}
