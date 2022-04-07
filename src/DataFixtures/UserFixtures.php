<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function load(ObjectManager $manager): void
    {


        $admin = new User();
        $admin->setUsername('Eosfel97');
        $admin->setEmail('admin@demo.fr');
        $admin->setLastname('Gnahiet');
        $admin->setFirstname('Any');
        $admin->setAddress('12 rue du port');
        $admin->setZipcode('75001');
        $admin->setTown('Paris');
        $admin->setPhone('Paris');
        $admin->setCountry('Paris');
        $admin->setCrearted(new \DateTime);
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $faker = Faker\Factory::create('fr_FR');
        for ($nbUser = 1; $nbUser <= 10; $nbUser++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword('azerty1997');
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setPhone($faker->phoneNumber);
            $user->setAddress($faker->address);
            $user->setUsername($faker->name);
            $user->setTown($faker->city);
            $user->setCountry($faker->country);
            $user->setZipCode($faker->postcode);
            $user->setCrearted(new \DateTime);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'azerty1997')
            );
            $user->setIsVerified($faker->numberBetween(0, 1));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
