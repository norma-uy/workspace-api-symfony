<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class GuzzleClientTest extends TestCase
{
    public function testSomething(): void
    {
        // Create a client with a base URI
        $client = new Client(['base_uri' => 'https://api.github.com/']);

        // Send a request to orgs/perseus-uy
        $response = $client->request('GET', 'orgs/perseus-uy');

        var_dump(json_decode($response->getBody(), true));

        $this->assertTrue(true);
    }
}
