<?php
namespace FastApi\Http;

use Swoole\Http\Request as SwooleRequest;

class Request
{
    /**
     * @var SwooleRequest
     */
    protected SwooleRequest $request;

    /**
     * Create Request
     *
     * @param SwooleRequest $request
     */
    public function __construct(SwooleRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get request uri.
     *
     * @return string
     */
    public function uri()
    {
        return $this->request->server['request_uri'];
    }

    /**
     * Get request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->request->server['request_method'];
    }

    /**
     * Access SwooleRequest properties.
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->request->$name;
    }
}