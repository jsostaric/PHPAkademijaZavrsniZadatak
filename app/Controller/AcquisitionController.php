<?php


namespace App\Controller;


use App\Model\Acquisition\AcquisitionRepository;
use App\Model\Acquisition\AcquisitionResource;
use App\Model\Product\ProductRepository;

class AcquisitionController extends Controller
{
    private $productRepository;
    private $acquisitionRepository;
    private $acquisitionResource;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductRepository();
        $this->acquisitionRepository = new AcquisitionRepository();
        $this->acquisitionResource = new AcquisitionResource();
    }

    public function indexAction()
    {
        if($this->session->getUser()->getAdmin()){
            $products = [];
            if(isset($_POST['searchItem'])){
                $term = $this->searchAction($_POST['searchItem']);
                $products = $this->productRepository->getProducts($term);
            }

            $acquisitionCart = $this->acquisitionRepository->getFromCart();
            $productInCart = [];
            foreach ($acquisitionCart as $itemInCart){
                $productId = $itemInCart->getProducts();
                $conditionId = $itemInCart->getConditions();
                $productInCart[] = $this->productRepository->getOne($productId, $conditionId);
            }

            $total = 0;

            foreach ($productInCart as $item){
                $total += $item->buyPrice;
            }

            return $this->view->render('acquisition/index',compact('products', 'total', 'productInCart'));
        }

        header('Location; /~polaznik22/');
    }

    protected function searchAction($term)
    {
        $term = trim($_POST['searchItem']);
        $term = "%{$term}%";

        return $term;
    }

    public function addToCartAction()
    {
        $productId = $_POST['productId'];
        $conditionId = $_POST['condition'];
        $product = $this->productRepository->getOne($productId, $conditionId);
        $this->acquisitionResource->insertInCart($product);

        header('Location: /~polaznik22/acquisition');
    }

    public function processAction()
    {
        var_dump($_POST);
    }

    public function removeAction()
    {
        if(isset($_POST['itemId'])){
            $itemId = $_POST['itemId'];
            $this->acquisitionResource->removeItem($itemId);

            header('Location: /~polaznik22/acquisition');
        }
    }
}