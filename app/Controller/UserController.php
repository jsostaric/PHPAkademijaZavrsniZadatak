<?php


namespace App\Controller;


class UserController extends Controller
{
    public function showAction()
    {
        $this->view->render('user/show');
    }

    public function editAction()
    {
        $this->view->render('user/edit');
    }
}