<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageControllerTest extends WebTestCase
{
    /**
     * @return void
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('Form');
    }

    /**
     * @return void
     */
    public function testDisplayForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('label', 'Imię');
    }
}
