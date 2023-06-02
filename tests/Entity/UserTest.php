<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Egulias\EmailValidator\Warning\TLD;

class UserTest extends TestCase
{
    public function testUsername()
    {
        $user = new User;
        $user->setUsername('TestUsername');
        $this->assertSame($user->getUsername(), 'TestUsername');

    }


    public function testgetUserIdentifier()
    {
        $user = new User;
        $user->setUsername('TestUsername');
        $this->assertSame($user->getUsername(), $user->getUserIdentifier());

    }


    public function testPassword()
    {
        $user = new User;
        $user->setPassword('TestPassword');
        $this->assertSame($user->getPassword(), 'TestPassword');

    }


    public function testEmail()
    {
        $user = new User;
        $user->setEmail('TestEmail');
        $this->assertSame($user->getEmail(), 'TestEmail');

    }


    public function testAddTask()
    {
        $user = new User;
        $task = new Task;
        $user->addTask($task);

        $this->assertContains($task, $user->getTasks());

        return $user;

    }


    /**
     * @depends testAddTask
     * 
     * @param User $user param
     *
     * @return void
     */
    public function testRemoveTask($user)
    {
        $tasks = $user->getTasks();
        $user->removeTask($tasks[0]);

        $this->assertEmpty($user->getTasks());

    }


}
