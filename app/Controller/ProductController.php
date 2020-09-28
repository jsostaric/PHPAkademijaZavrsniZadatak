<?php


namespace App\Controller;


use App\Model\Product\ProductRepository;
use App\Model\Category\CategoryRepository;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductRepository();
    }

    public function indexAction()
    {
        if(!$this->session->getUser()->getAdmin()){
            header('Location: /');
        }

        $products = $this->productRepository->getList();

        $data = [
            'products' => $products
        ];

        return $this->view->render('product/index', $data);
    }

    public function createAction()
    {
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getList('Book');

        return $this->view->render('product/create', compact('categories'));
    }

    public function storeAction()
    {

    }

    public function editAction()
    {
        $id = $_GET['id'];
    }

    public function updateAction()
    {

    }

    public function destroyAction()
    {

    }
}