<?php


namespace App\Controller;


use App\Core\Session;
use App\Model\User\UserRepository;
use App\Model\User\UserResource;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->userResource = new UserResource();
    }

    public function indexAction()
    {
        if($this->session->isLoggedIn()){
            $uid = $this->session->getUser()->getId();
            $user = $this->userRepository->getUserById($uid);


            return $this->view->render('user/index', compact('user'));
        }

        header('Location: /~polaznik22/');
    }

    public function editAction()
    {
        if($this->session->isLoggedIn()){

            return $this->view->render('user/edit');
        }

    }

    public function updateAction()
    {
        $message = $this->userRepository->passwordCheck($_POST);

        if($message != ''){
            $this->view->render('user/edit', compact('message'));
        }else{
            try {
                $this->userResource->updatePassword($_POST);

                $success = 'You successfully changed your password.';
                header('Location: /~polaznik22/user');
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }
}