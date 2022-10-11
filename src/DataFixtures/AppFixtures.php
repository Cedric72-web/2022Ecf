<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User($this->passwordHasher);
        $admin->setUsername("N0tCedric")
                ->setPassword('azerty')
                ->setEmail("admin@test.com")
                ->setRoles(["ROLE_ADMIN"])
                ->setCreatedAt(new \DateTime());
        $manager->persist($admin);
        $franchise1 = new User($this->passwordHasher);
        $franchise1->setUsername("N0tUser1")
                ->setPassword('azerty')
                ->setEmail("user1@test.com")
                ->setRoles(["ROLE_FRANCHISE"])
                ->setCreatedAt(new \DateTime());
        $manager->persist($franchise1);

        $manager->flush();
    }
}