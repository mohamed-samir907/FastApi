<?php

namespace Core;

use Exception;
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

class App
{
    use Router;

    private string $host;

    private int $port;

    private Server $server;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function init()
    {
        $this->server = new Server($this->host, $this->port);

        return $this->server;
    }

    /**
     * Handle incoming requests.
     *
     * @param  callable $callback
     * @return void
     */
    public function handleRequest(Request $request)
    {
        $requestUrl = $request->server['request_uri'];
        $requestMethod = $request->server['request_method'];

        if (!array_key_exists($requestUrl, $this->routes)) {
            throw new Exception("Page not found", 404);
        }

        $route = $this->routes[$requestUrl];

        if ($requestMethod !== $route['method']) {
            throw new Exception("Method not allowed for this route", 405);
        }

        return $route['action']($request);
    }

    /**
     * Run the server.
     *
     * @param  callable $callback
     * @return void
     */
    public function listen(callable $callback = null)
    {
        $callback = $callback ? $callback : function (Server $server) {
            echo "Listen to http://{$this->host}:{$this->port}\n";
        };

        $this->server->on("start", $callback);

        $this->server->on("request", function (Request $request, Response $response) {

            try {
                $data = $this->handleRequest($request);
            } catch (Exception $e) {
                $data = json_encode([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
            }

            $response->header('Content-Type', 'application/json');
            $response->write($data);
        });

        $this->server->start();
    }
}
