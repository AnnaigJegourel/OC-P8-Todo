<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;
    private $testUser;
    private $testTaskId;

    public function setUp(): void
    {
        $this->client = static::createClient();

        // Use the user repository.
        $userRepository = static::getContainer()->get(UserRepository::class);
        // Fetch the test user.
        $this->testUser = $userRepository->findOneByUsername('User-4');
        $this->testTaskId = $this->testUser->getTasks()->first()->getId();
    }

    public function testTodoListPageIsUpWhileLoggedIn(): void
    {        
        // Simulate $testUser being logged in.
        $this->client->loginUser($this->testUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request('GET', $urlGenerator->generate('task_list'));

        $this->assertResponseStatusCodeSame(200);
    }

    public function testDoneListPageIsUpWhileLoggedIn(): void
    {
        $this->client->loginUser($this->testUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request('GET', $urlGenerator->generate('task_done'));

        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreatePageIsUpWhileLoggedIn(): void
    {
        $this->client->loginUser($this->testUser);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request('GET', $urlGenerator->generate('task_create'));

        $this->assertResponseStatusCodeSame(200);
    }

    public function testEditPageIsUpForAuthor(): void
    {
        $this->client->loginUser($this->testUser);

        $crawler = $this->client->request('GET', '/tasks/'.$this->testTaskId.'/edit');

        $this->assertResponseStatusCodeSame(200);
    }

    // tester les redirections: toggle, delete
    public function testToggleRedirect(): void
    {
        $this->client->loginUser($this->testUser);

        $crawler = $this->client->request('GET', '/tasks/'.$this->testTaskId.'/toggle');

        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testDeleteRedirect(): void
    {
        $this->client->loginUser($this->testUser);

        $crawler = $this->client->request('GET', '/tasks/'.$this->testTaskId.'/delete');

        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

}
