<?php

namespace FastApi\Facades;

abstract class Facade
{
    /**
     * Get the object.
     *
     * @return object
     */
    abstract public static function getFacadeObject();

    /**
     * Handle object methods to be called statically.
     *
     * @param  string $method
     * @param  mixed $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        $class = static::getFacadeObject();

        return $class->$method(...$arguments);
    }
}