<?php

namespace App\DataFixtures;

use App\Entity\Advert;
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

        $roles = ['ROLE_RICHIEDENTE', 'ROLE_JOBBER'];
        $categoryLabel = ["Bricolage", "Giardinaggio", "Trasloco", "Servizio di babysitter", "Animali", "Informatica", "Lezioni private", "Aiuto domestico", "Lavori di casa"];
        $slugCategories = ["bricolage", "giardinaggio", "trasloco", "servizio-di-babysitter", "animali", "informatica", "lezioni-private", "aiuto-domestico", "lavori-di-casa"];
        $categories = [];
        $users = [];
        
        
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

        // User
        for ($i=0; $i < 50; $i++) {
            $user = new User();

            $hashedPassword = $this->passwordHasher->hashPassword($user, "password");

            $user->setEmail($faker->email())
                ->setPassword($hashedPassword)
                ->setFirstname($faker->firstname())
                ->setLastname($faker->lastname())
                ->setPhone($faker->phoneNumber())
                ->setAddress($faker->streetAddress())
                ->setPostCode($faker->postcode())
                ->setCity($faker->city())
                ->setRoles([$roles[mt_rand(0, count($roles) - 1 )]])
                ->setPresentation($faker->realText(100));

                $users[] = $user;

            $manager->persist($user);
        }

        // Category
        for ($i=0; $i < count($categoryLabel); $i++) { 
            $category = new Category();
            
            $category->setName($categoryLabel[$i])
                    ->setImage($img[$i])
                    ->setSlug($slugCategories[$i]);
            $categories[] = $category;

            $manager->persist($category);
        }


        // Annonces
        for ($i=0; $i < 100; $i++) { 
            $advert = new Advert();

            $cate = $categories[mt_rand(1, count($categories) - 1)];

            $advert->setTitle($faker->sentence(5))
                    ->setCategory($cate)
                    ->setDescription($faker->text())
                    ->setPhone("TODO")
                    ->setAddress("TODO")
                    ->setCategories($cate)
                    ->setUser($users[mt_rand(0, count($users) - 1 )]);

            $manager->persist($advert);
        }

        // Admin
        $admin = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($admin, "password");
        $admin->setEmail('admin@admin.com')
        ->setPassword($hashedPassword)
        ->setFirstname($faker->firstname())
        ->setLastname($faker->lastname())
        ->setPhone($faker->phoneNumber())
        ->setAddress($faker->streetAddress())
        ->setPostCode($faker->postcode())
        ->setCity($faker->city())
        ->setRoles(['ROLE_ADMIN', 'ROLE_RICHIEDENTE', 'ROLE_JOBBER'])
        ->setPresentation($faker->realText(100));

        $manager->persist($admin);




        $manager->flush();
    }
}
