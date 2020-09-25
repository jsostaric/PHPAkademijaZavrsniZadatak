<?php


namespace App\Controller;

use App\Model\Product\ProductRepository;

class HomeController extends Controller
{
    private $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductRepository();
    }

    public function indexAction()
    {
        $products = $this->productRepository->getList();

        $data = [
            'products' => $products
        ];
        return $this->view->render('index', $data);
    }
}