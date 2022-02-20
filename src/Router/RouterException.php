<?php

namespace App\Router;

use Exception;

class RouterException extends Exception
{

    public function __construct($m)
    {
        if ($m == 'No matching routes') {
            $controller = "App\\Controller\\Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, 'error404'], []);
        }
    }
}
