<?php

namespace Plivo\Tests;



use PHPUnit\Framework\TestCase;
use Plivo\Authentication\BasicAuth;
use Plivo\PlivoApi;
use Plivo\PlivoClient;

/**
 * Class BaseTestCase
 * @package Plivo\Tests
 */
class BaseTestCase extends TestCase
{
    /**
     * @var PlivoApi
     */
    protected $client;
    /**
     * @var TestClient
     */
    protected $testClient = null;

    /**
     *
     */
    protected function setUp()
    {
        $this->client = new PlivoApi("MAXXXXXXXXXXXXXXXXXX", "AbcdEfghIjklMnop1234");
        $this->testClient = new TestClient(null,
            new BasicAuth("MAXXXXXXXXXXXXXXXXXX", "AbcdEfghIjklMnop1234"));
        $this->client->client->setHttpClientHandler($this->testClient);
    }

    /**
     * @param $request
     */
    public function assertRequest($request) {
        $this->testClient->assertRequest($request);
        self::assertTrue(true);
    }

    /**
     * @param $response
     */
    public function mock($response)
    {
        $this->testClient->mock($response);
    }
}