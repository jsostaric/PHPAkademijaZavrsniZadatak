<?php


namespace App\Controller;


use App\Model\Product\Product;

class ProductController extends Controller
{
    public function indexAction()
    {
        //check if logged in and admin
        return $this->view->render('admin/index');
    }

    public function showAction()
    {
        $id = $_GET['id'];
    }
}