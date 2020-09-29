<?php


namespace App\Core;


class Request
{
    public static function uri()
    {
        // tidy up URI on server
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $parts = explode('/', $uri);
        if($parts[0] === '~polaznik22'){
            unset($parts[0]);
        }

        return $uri = implode('/', $parts);
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
