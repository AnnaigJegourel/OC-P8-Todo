<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
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
        // Load users.
        for ($i = 0; $i < 5; $i++) {
            $user = new User;

            // $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password'.$i));
            $user->setEmail('user'.$i.'@mail.com');
            $user->setUsername('User'.$i);

            $manager->persist($user);
        }

        // Load tasks.
        for ($i = 0; $i < 20; $i++) {
            $task = new Task;

            $task->setTitle('Task'.$i);
            $task->setContent('This is the description of task .$i');
            $task->setCreatedAt(new \DateTime());
            for ($i = 0; $i < 8; $i++) {
                $task->isDone();
            }

            $manager->persist($task);
        }

        $manager->flush();
    }
}
