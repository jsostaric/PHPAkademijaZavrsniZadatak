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

    public function searchAction()
    {
        $term = $_POST['search'];
        $term = trim($term, '');
        $term = "%$term%";

        $products = $this->productRepository->getProducts($term);

        if($this->session->isLoggedIn() && $this->session->getUser()->getAdmin()){
            return $this->view->render('product/index', compact('products'));
        }else{
            return $this->view->render('index', compact('products'));
        }
    }
}