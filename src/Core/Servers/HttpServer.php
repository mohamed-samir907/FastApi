<?php

namespace FastApi\Core\Servers;

use Swoole\Http\Server;;
use FastApi\Core\Servers\AbstractServer;

class HttpServer extends AbstractServer
{
    /**
     * Create Http Server.
     *
     * @param  string $host
     * @param  int $port
     * @param  mixed $mode
     * @param  mixed $sockType
     */
    public function __construct($host, $port, $mode = null, $sockType = null)
    {
        $this->host     = $host;
        $this->port     = $port;
        $this->server   = new Server($host, $port);
    }

    /**
     * @inheritDoc
     */
    public function listen()
    {
        $this->onStart();

        $this->onRequest();

        $this->server->start();
    }

    /**
     * Handle on start server.
     *
     * @param  callable $callback
     * @return void
     */
    public function onStart(callable $callback = null)
    {
        $callback = $callback ?? function (Server $server) {
            echo "Listen to http://{$this->host}:{$this->port}\n";
        };

        $this->server->on("start", $callback);
    }
}