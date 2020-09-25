<?php


namespace App\Controller;


class AuthController extends Controller
{
    private $session;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
    }

    public function loginAction()
    {
        return $this->view->render('login');
    }

    public function loginSubmitAction()
    {

    }

    public function registerAction()
    {
        return $this->view->render('register');
    }

    public function registerSubmitAction()
    {
        return;
    }
}