<?php


namespace App\Controller;


use App\Model\Acquisition\AcquisitionCartRepository;
use App\Model\Acquisition\AcquisitionCartResource;
use App\Model\Acquisition\AcquisitionResource;
use App\Model\Acquisition\AcquisitionRepository;
use App\Model\Product\ProductRepository;

class AcquisitionController extends Controller
{
    private $productRepository;
    private $acquisitionCartRepository;
    private $acquisitionRepository;
    private $acquisitionCartResource;
    private $acquisitionResource;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductRepository();
        $this->acquisitionCartRepository = new AcquisitionCartRepository();
        $this->acquisitionRepository = new AcquisitionRepository();
        $this->acquisitionResource = new AcquisitionResource();
        $this->acquisitionCartResource = new AcquisitionCartResource();
    }

    public function indexAction()
    {
        if($this->session->getUser()->getAdmin()){
            $acquisitions = $this->acquisitionRepository->getList();

            if(isset($_POST['searchItem'])){
                $acquisitions = $this->acquisitionRepository->getAcquisitions($_POST['searchItem']);
            }

            return $this->view->render('acquisition/index', compact('acquisitions'));
        }

        header('Location: /~polaznik22/');
    }

    public function createAction()
    {
        if($this->session->getUser()->getAdmin()){
            $products = [];
            if(isset($_POST['searchItem'])){
                $products = $this->productRepository->getProducts($_POST['searchItem']);
            }

            $acquisitionCart = $this->acquisitionCartRepository->getFromCart();
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

            return $this->view->render('acquisition/create',compact('products', 'total', 'productInCart'));
        }

        header('Location: /~polaznik22/');
    }

    public function showAction()
    {
        $acquisitionsId = isset($_GET['acquisitionId']) ? $_GET['acquisitionId'] : '';
        $acquiredProducts = $this->acquisitionRepository->getAcquired($acquisitionsId);
        $products = [];
//        $receipt = [];
        foreach ($acquiredProducts as $acquired){
//            $receipt[] = $acquisitionsId . '-' . $acquired->id;
            $products[] = $this->productRepository->getOne($acquired->products, $acquired->conditions);
        }

        $this->view->render('acquisition/show', compact('products'));
    }

    public function addToCartAction()
    {
        $productId = $_POST['productId'];
        $conditionId = $_POST['condition'];
        $product = $this->productRepository->getOne($productId, $conditionId);
        $this->acquisitionCartResource->insertInCart($product);

        header('Location: /~polaznik22/acquisition/create');
    }

    public function processAction()
    {
        //new entry in acquisitions table
        $total = $_POST['total']; //total
        $acquisitionId = $this->acquisitionResource->insert($total);

        //get AcqCart
        $getCart = $this->acquisitionCartRepository->getFromCart();

        //insert into Acq_products
        foreach ($getCart as $item){
            $products = $this->acquisitionResource->insertInAcquired($item, $acquisitionId);
        }

        //clear cart
        $this->acquisitionCartResource->clearCart();

        //redirect to acquisitions list
        return $this->view->render('acquisition/create');
    }

    public function removeAction()
    {
        if(isset($_POST['itemId']) && isset($_POST['conditionId'])){
            $itemId = $_POST['itemId'];
            $conditionId = $_POST['conditionId'];
            $itemInCartId = $this->acquisitionCartRepository->getItemInCartId($itemId, $conditionId);
            $this->acquisitionCartResource->removeItem($itemInCartId);

            header('Location: /~polaznik22/acquisition/create');
        }
    }
}