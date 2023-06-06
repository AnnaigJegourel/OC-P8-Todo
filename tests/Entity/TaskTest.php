<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTitle()
    {
        $task = new Task;
        $task->setTitle('Testitle');
        $this->assertSame($task->getTitle(), 'Testitle');

    }


    public function testisDone()
    {
        $task = new Task;
        $this->assertSame(false, $task->isDone());

    }


    public function testAuthorType()
    {
        $task = new Task;
        $author = new User;

        $task->setAuthor($author);
        $this->assertSame(true, $task->getAuthor() instanceof User);

    }


}
