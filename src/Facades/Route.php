<?php

namespace FastApi\Facades;

use FastApi\Facades\Facade;
use FastApi\Router\Route as Router;

class Route extends Facade
{
    /**
     * @inheritDoc
     */
    public static function getFacadeObject()
    {
        return Router::getInstance();
    }
}
