<?php

namespace Core;

trait Router
{
    protected array $routes = [];

    public function route(string $method, string $path, callable $callback)
    {
        $this->routes[$path] = [
            'method' => $method,
            'action' => $callback
        ];
    }

    public function get(string $path, callable $callback)
    {
        $this->route('GET', $path, $callback);
    }

    public function post(string $path, callable $callback)
    {
        $this->route('POST', $path, $callback);
    }

    public function delete(string $path, callable $callback)
    {
        $this->route('DELETE', $path, $callback);
    }

    public function put(string $path, callable $callback)
    {
        $this->route('PUT', $path, $callback);
    }

    public function patch(string $path, callable $callback)
    {
        $this->route('PATCH', $path, $callback);
    }
}