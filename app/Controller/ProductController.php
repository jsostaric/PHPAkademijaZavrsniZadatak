<?php


namespace App\Controller;


use App\Model\Product\ProductRepository;
use App\Model\Category\CategoryRepository;
use App\Model\Product\ProductResource;

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
        $resource = new ProductResource();
        $image = null;
        //validate and sanitize picture
        if($_FILES['image']['error'] === 0){
            $image = $resource->validateImage($_FILES);
        }

        //validate new product data
        $postData = $resource->validate($_POST);

        //insert data
        $resource->insert($image, $postData);

        header('Location: /~polaznik22/product');
    }
}