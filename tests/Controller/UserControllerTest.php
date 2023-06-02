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
        $this->client->request('GET', $urlGenerator->generate('user_list'));

        $this->assertResponseStatusCodeSame(200);

    }


    public function testCreateUserFormAsAdmin()
    {

        // Create page is up.
        $this->client->loginUser($this->testAdmin);

        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request('GET', $urlGenerator->generate('user_create'));

        $this->assertResponseStatusCodeSame(200);

        // Send form.
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'TestUser';
        $form['user[password][first]'] = 'test-password';
        $form['user[password][second]'] = 'test-password';
        $form['user[email]'] = 'user@test.fr';

        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success','Superbe !');

    }


    public function testEditUserFormAsAdmin(): void
    {

        // Edit page is up.
        $this->client->loginUser($this->testAdmin);
        $crawler = $this->client->request('GET', '/users/1/edit');
        $this->assertResponseStatusCodeSame(200);

        // Send form.
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'RE-TestUser';
        $form['user[password][first]'] = 'RE-test-password';
        $form['user[password][second]'] = 'RE-test-password';
        $form['user[email]'] = 'RE-user@test.fr';

        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertRouteSame('user_list');

    }


}
