<?php

namespace FastApi\Router;

use FastApi\Http\Request;
use FastApi\Router\Exceptions\MethodNotAllowed;
use FastApi\Router\Exceptions\NotFound;
use FastApi\Router\Exceptions\NotValid;

class Route
{
    /**
     * Routes Registery.
     *
     * @var array
     */
    private $routes = [];

    /**
     * Route class instance.
     *
     * @var self|null
     */
    private static $instance;

    /**
     * Constrcutor.
     */
    private function __construct() {}

    /**
     * Get instance from the Route class.
     *
     * @var self
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Add route to the routes registery.
     *
     * @param  array $methods
     * @param  string $uri
     * @param  callable $callback
     * @return void
     */
    private function add(array $methods, string $uri, callable $callback)
    {
        $uri = "/" . trim($uri, "/");

        $uri = $uri ?? '/';

        foreach ($methods as $method) {
            $this->routes[] = [
                'method' => $method,
                'uri' => $uri,
                'callback' => $callback
            ];
        }
    }

    /**
     * Add GET route.
     *
     * @param  string $uri
     * @param  callable $callback
     * @return void
     */
    public function get($uri, $callback)
    {
        $this->add(['GET'], $uri, $callback);
    }

    /**
     * Add POST route.
     *
     * @param  string $uri
     * @param  callable $callback
     * @return void
     */
    public function post($uri, $callback)
    {
        $this->add(['POST'], $uri, $callback);
    }

    /**
     * Get all routes.
     *
     * @return array
     */
    public function allRoutes()
    {
        return $this->routes;
    }

    /**
     * Match the request with routes.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        list($route, $matches) = $this->getMatchedRoute($request);

        return $this->handleMatchedRoute($route, $matches, $request);
    }

    /**
     * Get the registered route that matches the request url.
     *
     * @param  Request $request
     * @return array
     * @throws Exception
     */
    private function getMatchedRoute(Request $request)
    {
        foreach ($this->routes as $route) {

            // Replace all route params with pattern to match it with the url.
            $route['uri'] = preg_replace('/{(.*?)}/', '([^.*?])', $route['uri']);
            $route['uri'] = '#^' . $route['uri'] . '/$#';

            // Add trailing slash to the url to match it correctly with the pattern.
            $url = $request->uri() == '/' ? '//' : rtrim($request->uri(), '/') . '/';

            if (preg_match($route['uri'], $url, $matches)) {
                array_shift($matches);

                return [$route, $matches];
            }
        }

        throw new NotFound("Not found", 404);
    }

    /**
     * Handle Matched Route.
     *
     * @param  array $route
     * @param  array $matches
     * @param  Request $request
     * @return mixed
     */
    private function handleMatchedRoute($route, $matches, $request)
    {
        $params = array_values($matches);

        // Check if the param has '/' in it's value
        foreach ($params as $param) {
            if (strpos($param, '/')) {
                throw new NotValid("Parameter not valid", 422);
            }
        }

        if ($route['method'] !== $request->method()) {
            throw new MethodNotAllowed("Method not allowed", 405);
        }

        $callback = $route['callback'];

        if (is_callable($callback)) {
            return call_user_func($callback, ...$params);
        }
    }
}
