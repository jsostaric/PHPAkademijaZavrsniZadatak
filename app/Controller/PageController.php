<?php


namespace App\Controller;


class PageController extends Controller
{
    public function indexAction()
    {
        return $this->view->render('index');
    }
}