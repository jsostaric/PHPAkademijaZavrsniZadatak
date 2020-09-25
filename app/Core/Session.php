<?php


namespace App\Core;


class Session extends DataObject
{
    protected static $instance;

    public function __construct($data = [])
    {
        parent::__construct($data);
        session_start();
    }

    public function __set($key, $value)
    {
        parent::__set($key, $value);
        $_SESSION[$key] = $value;
    }

    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
    }
}