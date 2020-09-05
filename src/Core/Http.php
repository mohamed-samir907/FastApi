<?php

namespace FastApi\Core;

use Swoole\Coroutine\HTTP\Client;

class Http
{
    private Client $client;

    public function __construct(string $host)
    {
        $this->client = new Client($host);
    }

    public function addHeaders(array $headers)
    {
        $this->client->setHeaders($headers);
    }

    public function timeout(int $seconds = 2)
    {
        $this->client->set(['timeout' => $seconds]);
    }

    public function get(string $endpoint)
    {
        $this->client->get($endpoint);
        $this->client->close();

        return $this->client->body;
    }
}
