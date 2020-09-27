<?php


namespace App\Core;



class Session extends DataObject
{
    protected static $instance;

    private function __construct($data = [])
    {
        parent::__construct($data);
        session_start();
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

    public function login($user)
    {
        return $_SESSION['user'] = $user;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    public function getUser()
    {
        return $_SESSION['user'];
    }
}