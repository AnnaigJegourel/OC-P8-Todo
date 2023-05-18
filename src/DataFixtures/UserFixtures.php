<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    /**
     * Hash password
     *
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * Fixtures constructor
     *
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * Load the fixtures
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Load one admin.
        $user = new User;

        $user->setUsername('Admin');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password-admin'));
        $user->setEmail('admin@email.com');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        // Load users.
        for ($i = 0; $i < 5; $i++) {
            $user = new User;

            $user->setUsername('User-'.$i);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password-'.$i));
            $user->setEmail('user-'.$i.'@email.com');
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
