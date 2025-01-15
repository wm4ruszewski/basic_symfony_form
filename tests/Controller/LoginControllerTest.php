<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    /**
     * @return void
     */
    public function testFailedLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(200);

        $form = $crawler->selectButton('Zaloguj')->form();

        $form['_username'] = 'wrong';
        $form['_password'] = 'wrong';

        $client->submit($form);

        $this->assertResponseRedirects('/login');
    }

    /**
     * @return void
     */
    public function testCorrectLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(200);

        $form = $crawler->selectButton('Zaloguj')->form();

        $form['_username'] = 'test';
        $form['_password'] = 'test';

        $client->submit($form);

        $this->assertResponseRedirects('/list');
    }

}
