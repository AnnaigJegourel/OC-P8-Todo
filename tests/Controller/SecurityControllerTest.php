<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginFormSuccessful(): void
    {
        // Form page is up.
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(200);

        // Send form with correct credentials.
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'User-0';
        $form['_password'] = 'password-0';

        $client->submit($form);
        $client->followRedirect();
        $this->assertRouteSame('homepage');
    }

    // tester logout, login_check?!
}
