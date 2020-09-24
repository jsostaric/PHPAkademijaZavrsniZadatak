<?php


namespace App\Core;


class Database extends \PDO
{
    private static $instance;

    private function __construct()
    {
        $dbConfig = Config::get('database');
        $dsn = 'mysql:host=' . $dbConfig['dbhost'] .
            ';dbname=' . $dbConfig['dbname'] . ';charset=utf8';

        parent::__construct($dsn, $dbConfig['username'], $dbConfig['password']);

        $this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new self;
        }

        return self::$instance;
    }
}