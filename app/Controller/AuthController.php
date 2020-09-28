<?php


namespace App\Controller;



use App\Model\User\UserRepository;
use App\Model\User\UserResource;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function loginAction()
    {
        if(!$this->session->isLoggedIn()){
            return $this->view->render('login');
        }
        header('Location: /');
    }

    public function loginSubmitAction()
    {
        $user = $this->validateLoginData($_POST);

        //log in user
        $this->session->login($user);

        if($this->session->getUser()->getAdmin()){
            header('Location: product');
            return;
        }

        header('Location: /');
    }

    public function registerAction()
    {
        if(!$this->session->isLoggedIn()){
            return $this->view->render('register');
        }

        header('Location: /');
    }

    public function registerSubmitAction()
    {
        $data = $_POST;

        //check if all boxes are filled
        if(empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['repeatPassword'])){
            header('Location: register');
            return;
        }

        //check if user exist
        $user = $this->userRepository->getUserByEmail($data['email']);
        if(!empty($user)){
            header('Location: register');
            return;
        }

        //check if password and repeat password is same
        if($data['password'] !== $data['repeatPassword']){
            header('Location: register');
            return;
        }

        //insert user and redirect
        $resource = new UserResource();
        $resource->insertUser($data);

        header('Location: login');
    }

    public function logoutAction()
    {
        $this->session->logout();
        header('Location: /');
    }

    public function validateLoginData($data)
    {
        $email = $data['email'];
        $password = $data['password'];

        //check if $_POST is empty
        if(empty($email) || empty($password)){
            header('Location: login');
        }

        //check credentials
        $user = $this->userRepository->getUserByEmail($email);
        if(empty($user)){
            header('Location: login');
        }

        $databasePassword = $user->getPassword();

        if(!password_verify($password, $databasePassword)){
            header('Location: login');
        }

        return $user;
    }
}