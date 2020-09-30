<?php


namespace App\Model\Product;


use App\Core\Database;

class ProductRepository
{
    public function getList()
    {
        $list = [];
        $db = Database::getInstance();
        $stmt = $db->prepare('select  a.*, group_concat(distinct c.name) as category, e.name as conditions, d.amount, d.sellPrice, d.buyPrice
                from products a 
                inner join product_categories b on a.id = b.products
                inner join categories c on c.id = b.categories
                inner join product_conditions d on d.products = a.id
                inner join conditions e on e.id = d.conditions
                group by a.title, conditions;');
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $product){
            $list[] = new Product([
               'id' => $product->id,
               'title' => $product->title,
               'subtitle' => $product->subtitle,
               'author' => $product->author,
               'publisher' => $product->publisher,
               'year' => $product->year,
               'format' => $product->format,
                'image' => $product->image,
                'category' => $product->category,
                'amount' => $product->amount,
                'conditions' => $product->conditions,
                'sellPrice' => $product->sellPrice,
                'buyPrice' => $product->buyPrice
            ]);
        }
        return $list;
    }

    public function getProducts($term)
    {
        $list = [];
        $db = Database::getInstance();
        $sql = 'select  a.*, group_concat(distinct c.name) as category, e.name as conditions, d.amount, d.sellPrice, d.buyPrice
                from products a 
                inner join product_categories b on a.id = b.products
                inner join categories c on c.id = b.categories
                inner join product_conditions d on d.products = a.id
                inner join conditions e on e.id = d.conditions
                where a.title like :term or a.subtitle like :term or a.barcode like :term
                group by a.title, conditions';
        $stmt = $db->prepare($sql);
        $stmt->execute([
           'term' => $term
        ]);
        foreach ($stmt->fetchAll() as $product){
            $list[] = new Product([
                'id' => $product->id,
                'title' => $product->title,
                'subtitle' => $product->subtitle,
                'author' => $product->author,
                'publisher' => $product->publisher,
                'year' => $product->year,
                'format' => $product->format,
                'image' => $product->image,
                'category' => $product->category,
                'amount' => $product->amount,
                'conditions' => $product->conditions,
                'sellPrice' => $product->sellPrice,
                'buyPrice' => $product->buyPrice
            ]);
        }

        return $list;
    }

    public function getOne($data)
    {
        $productId = $data['productId'];

        $db = Database::getInstance();
        $sql = "select a.id, a.title, a.subtitle, a.author, c.name as conditions, b.sellPrice, b.amount
                from products a
                inner join product_conditions b on b.products=a.id
                inner join conditions c on c.id=b.conditions
                where a.id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id' => $productId
        ]);

        $result = $stmt->fetch();

        return $result;
    }
}