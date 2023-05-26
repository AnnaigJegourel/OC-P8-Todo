<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load the fixtures
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Load 15 fixtures
        for ($i = 0; $i < 15; $i++) {
            $task = new Task;

            $task->setCreatedAt(new \DateTime());
            $task->setTitle('Task'.$i);
            $task->setContent('This is the description of task'.$i);

            // The last 5 tasks have an author.
            if($i > 5) {
                $random = rand(0, 4);
                $task->setAuthor($this->getReference('user'.$random));
            }

            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
