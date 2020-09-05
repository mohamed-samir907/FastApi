<?php

namespace FastApi\Core;

use FastApi\Core\Servers\AbstractServer;
use FastApi\Core\Servers\HttpServer;
use FastApi\Core\Servers\WebsocketServer;

class App
{
    /**
     * Server host address.
     * 
     * @var string
     */
    private string $host;

    /**
     * Server Port.
     * 
     * @var int
     */
    private int $port;

    /**
     * Used Server.
     * 
     * @var AbstractServer
     */
    private AbstractServer $server;

    /**
     * Create application instance.
     *
     * @param  string $host
     * @param  integer $port
     */
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Initialize the server connection.
     *
     * @param  bool $websocketEnabled
     * @return void
     */
    public function init(bool $websocketEnabled = false)
    {
        if ($websocketEnabled) {
            $this->server = new WebsocketServer($this->host, $this->port);
        } else {
            $this->server = new HttpServer($this->host, $this->port);
        }

        return $this->server;
    }

    /**
     * Run the server.
     *
     * @param  callable $callback
     * @return void
     */
    public function listen(callable $callback = null)
    {
        $this->server->listen($callback);
    }
}
