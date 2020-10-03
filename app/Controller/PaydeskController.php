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
                $term = trim($_POST['searchItem']);
                $term = "%{$term}%";
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

    public function addToCartAction()
    {
        $productId = $_POST['productId'];
        $condition = $_POST['conditionId'];
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

            $productResource->updateAmountDown($productId, $conditionId, $productAmount);
        }

        //create pdf receipt
        $this->createPdfReceipt();

        //remove from paydesk
        $this->paydeskResource->clearPaydesk();

        return $this->view->render('paydesk/index');
    }

    public function removeAction()
    {
        if(isset($_POST['itemId'])){
            $itemId = $_POST['itemId'];
            $this->paydeskResource->removeItem($itemId);

            header('Location: /~polaznik22/paydesk');
        }
    }

    public function createPdfReceipt()
    {
        $paydesk = $this->paydeskRepository->getList();

        // create it to pdf
        $pdf = new \App\Core\FPdf\Pdf();

        $header = array('Title', 'Subtitle', 'Author', 'Condition', 'Price');

        $pdf->SetFont('Arial', '', 10);
        $pdf->AddPage();
        $pdf->basicTable($header, $paydesk);

        $pdf->Output();
    }
}