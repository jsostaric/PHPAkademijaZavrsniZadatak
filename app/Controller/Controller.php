<?php


namespace App\Controller;

use App\Core\Session;
use App\Core\View;

class Controller
{
    protected $view;
    protected $session;

    public function __construct()
    {
        $this->view = new View;
        $this->session = Session::getInstance();
    }
}