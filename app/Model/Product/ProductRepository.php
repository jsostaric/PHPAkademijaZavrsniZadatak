<?php


namespace App\Model\Product;


use App\Core\Database;

class ProductRepository
{
    public function getList()
    {
        $list = [];
        $db = Database::getInstance();
        $stmt = $db->prepare('select * from products');
        $stmt->execute();
        foreach ($stmt->fetchAll() as $product){
            $list[] = new Product([
               'id' => $product->id,
               'title' => $product->title,
               'subtitle' => $product->subtitle,
               'author' => $product->author,
               'barcode' => $product->barcode,
               'retail_price' => $product->retail_price
            ]);
        }

        return $list;
    }
}