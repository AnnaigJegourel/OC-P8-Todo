<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;
    private $testAdmin;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->testAdmin = $userRepository->findOneByUsername('Admin');
    }

    public function testListPageIsUpForAdmin(): void
    {
        $this->client->loginUser($this->testAdmin);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request('GET', $urlGenerator->generate('user_list'));

        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreatePageIsUpForAdmin(): void
    {
        $this->client->loginUser($this->testAdmin);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request('GET', $urlGenerator->generate('user_create'));

        $this->assertResponseStatusCodeSame(200);
    }

    // with logged in as admin & with ID: user_edit (editAction())
}
