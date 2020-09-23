<?php


namespace App\Core;


class Request
{
    public static function uri()
    {

//        return trim(
//            parse_url(
//                $_SERVER['REQUEST_URI'], PHP_URL_PATH),
//            '/'
//        );

        // tidy up URI on server
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $parts = explode('/', $uri);
        unset($parts[0]);

        return $uri = implode('/', $parts);

    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}