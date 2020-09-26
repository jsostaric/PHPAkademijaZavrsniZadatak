<?php


namespace App\Controller;



use App\Model\User\UserRepository;
use App\Model\User\UserResource;

class AuthController extends Controller
{
    protected $session;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function loginAction()
    {
        if($this->session->isLoggedIn()){
            header('Location: /');
        }
        return $this->view->render('login');
    }

    public function loginSubmitAction()
    {
        //check if user is logged in
        if($this->session->isLoggedIn()){
            header('Location: /');
        }

        $data = $this->validateLoginData($_POST);

        //log in user
        $this->session->user = $data;

        header('Location: /');
    }

    public function registerAction()
    {
        if($this->session->isLoggedIn()){
            header('Location: /');
            return;
        }
        return $this->view->render('register');
    }

    public function registerSubmitAction()
    {
        $data = $_POST;
        //check if user is logged in
        if($this->session->isLoggedIn()){
            header('location: /');
        }

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

   public function logoutAction()
    {
        $this->session->logout();
        header('Location: /');
    }
}