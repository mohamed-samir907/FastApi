<?php

namespace FastApi\Core\Servers;

use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use FastApi\Core\Servers\AbstractServer;

class WebsocketServer extends AbstractServer
{
    /**
     * Create WebSocket Server with Http Server running at the same port.
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

        $this->server->on('open', function(Server $server, Request $request) {
            echo "connection open: {$request->fd}\n";
            $server->tick(1000, function() use ($server, $request) {
                $server->push($request->fd, json_encode(["hello", time()]));
            });
        });
        
        $this->server->on('message', function(Server $server, Frame $frame) {
            echo "received message: {$frame->data}\n";
            $server->push($frame->fd, json_encode(["hello", time()]));
        });
        
        $this->server->on('close', function(Server $server, int $fd) {
            echo "connection close: {$fd}\n";
        });

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
            echo "Http Server at http://{$this->host}:{$this->port}\n";
            echo "WebSocket Server at ws://{$this->host}:{$this->port}\n";
        };

        $this->server->on("start", $callback);
    }
}