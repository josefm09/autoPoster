<?php

namespace Tests\Functional;

class HomepageTest extends BaseTestCase
{
    /**
     * Test that the GET / route returns a rendered response with the form.
     */
    public function testGetHomepage()
    {
        $response = $this->runApp('GET', '/');
        $body = (string)$response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('<input type="text" name="name" placeholder="Enter your name">', $body);
        $this->assertStringContainsString('<button type="submit">Greet</button>', $body);
        // Ensure no greeting message is present on initial load
        $this->assertStringNotContainsString('<h2>Hello', $body);
    }

    /**
     * Test that POSTing to /greet with a name returns a greeting.
     */
    public function testPostToGreet()
    {
        $response = $this->runApp('POST', '/greet', ['name' => 'Jules']);
        $body = (string)$response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('<h2>Hello, Jules!</h2>', $body);
        // Check if form is still present
        $this->assertStringContainsString('<input type="text" name="name" placeholder="Enter your name">', $body);
        $this->assertStringContainsString('<button type="submit">Greet</button>', $body);
    }

    /**
     * Test that POSTing to /greet without a name returns the default greeting.
     */
    public function testPostToGreetWithNoName()
    {
        $response = $this->runApp('POST', '/greet', []); // Empty data
        $body = (string)$response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('<h2>Hello, World!</h2>', $body);
        // Check if form is still present
        $this->assertStringContainsString('<input type="text" name="name" placeholder="Enter your name">', $body);
        $this->assertStringContainsString('<button type="submit">Greet</button>', $body);
    }

    /**
     * Test that the index route won't accept a POST request
     */
    public function testPostHomepageNotAllowed()
    {
        $response = $this->runApp('POST', '/', ['test']);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertStringContainsString('Method not allowed', (string)$response->getBody());
    }
}