<?php


namespace App\Core;



class Session extends DataObject
{
    protected static $instance;
    private $currentUser;

    private function __construct($data = [])
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
        return isset($_SESSION['user']);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
    }
}