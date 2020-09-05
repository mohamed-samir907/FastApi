<?php

namespace FastApi\Core\Servers;

use Exception;
use Swoole\Http\Request;
use Swoole\Http\Response;
use FastApi\Console\Log as ConsoleLog;
use FastApi\Facades\Route;
use FastApi\Http\Request as HttpRequest;

abstract class AbstractServer
{
    /**
     * Server host address.
     * 
     * @var string
     */
    protected string $host;

    /**
     * Server Port.
     * 
     * @var int
     */
    protected int $port;

    /**
     * @var \Swoole\WebSocket\Server|\Swoole\Http\Server
     */
    protected $server;

    /**
     * Run the server.
     *
     * @return void
     */
    abstract public function listen();

    /**
     * Get the created server.
     *
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Handle requests comming to the server.
     *
     * @param  callable $callback
     * @return void
     */
    public function onRequest(callable $callback = null)
    {
        $callback = $callback ?? function (Request $request, Response $response) {

            $request = new HttpRequest($request);

            $resp = $this->prepareResponse($request) ?? "Welcome to FastApi Framework";

            $response->header('Content-Type', 'application/json');
            $response->write($resp);
        };

        $this->server->on("request", $callback);
    }

    /**
     * Handle incoming requests and return response.
     *
     * @param  HttpRequest $request
     * @return void
     */
    public function prepareResponse(HttpRequest $request)
    {
        try {
                
            $data = Route::handle($request);
            
            ConsoleLog::requestSuccess($request->server);

        } catch (Exception $e) {
            $data = json_encode([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);

            ConsoleLog::requestError($request->server, $e->getCode() . ' ' . $e->getMessage());
        }

        return $data;
    }
}
