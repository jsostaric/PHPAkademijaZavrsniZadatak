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

        if(isset($_POST['search'])){
            $term = trim($_POST['search']);
            $term = "%$term%";

            $products = $this->productRepository->getProducts($term);
        }


        $data = [
            'products' => $products
        ];

        return $this->view->render('index', $data);
    }

    public function searchAction()
    {


        return $this->view->render('index', compact('products'));
    }
}