<?php

define('BP',  dirname(__DIR__));

spl_autoload_register(function ($class){
    $class = lcfirst($class);
    $className = BP . DIRECTORY_SEPARATOR . strtr($class, '\\' , DIRECTORY_SEPARATOR) . '.php';

    if(file_exists($className)){
        return require_once $className;
    }
});

session_start();

App\Core\Router::load('../app/routes.php')
    ->direct(App\Core\Request::uri(), App\Core\Request::method());