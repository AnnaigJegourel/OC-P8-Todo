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

        $client->request('GET', '/login'); // connecté et retour sur login
        $client->followRedirect();
        $this->assertRouteSame('homepage');

    }
// test fail

}
