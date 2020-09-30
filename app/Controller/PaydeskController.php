<?php


namespace App\Controller;


use App\Model\Condition\ConditionRepository;
use App\Model\Paydesk\PaydeskRepository;
use App\Model\Paydesk\PaydeskResource;
use App\Model\Product\ProductRepository;
use App\Model\Product\ProductResource;

class PaydeskController extends Controller
{
    private $productRepository;
    private $paydeskRepository;
    private $paydeskResource;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductRepository();
        $this->paydeskRepository = new PaydeskRepository();
        $this->paydeskResource = new PaydeskResource();
    }

    public function indexAction()
    {
        if($this->session->getUser()->getAdmin()){
            $products = [];
            if(isset($_POST['searchItem'])){
                $term = $this->searchAction($_POST['searchItem']);
                $products = $this->productRepository->getProducts($term);
            }

            $paydesk = $this->paydeskRepository->getList();
            $total = 0;

            foreach ($paydesk as $item){
                $total += $item->sellPrice;
            }

            return $this->view->render('paydesk/index', compact('paydesk', 'total', 'products'));
        }

        header('Location: /~polaznik22/');
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
        $condition = $_POST['condition'];
        $product = $this->productRepository->getOne($productId,$condition);

        $this->paydeskResource->insert($product);

        header('Location: /~polaznik22/paydesk');
    }

    public function processAction()
    {
        $total = $_POST['total'];
        $paydesk = $this->paydeskRepository->getList();
        $productResource = new ProductResource();
        $conditionRepo = new ConditionRepository();

        foreach ($paydesk as $product){
            $productId = $product->getProducts();
            $productAmount = $product->amount;
            $productCondition = $product->conditions;
            $conditionId = $conditionRepo->getId($productCondition);

            $productResource->updateAmount($productId, $conditionId, $productAmount);
        }

        //create PDF of receipt


        //remove from paydesk
        $this->paydeskResource->clearPaydesk();

        $this->view->render('paydesk/index');
    }

    public function removeAction()
    {
        if(isset($_POST['itemId'])){
            $itemId = $_POST['itemId'];
            $this->paydeskResource->removeItem($itemId);

            header('Location: /~polaznik22/paydesk');
        }
    }
}