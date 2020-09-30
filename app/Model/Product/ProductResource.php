<?php


namespace App\Model\Product;


use App\Core\Database;

class ProductResource
{
    public function insert($image, $data)
    {
        $filename = null;

        try {
            if($image != null){
                $filename = $this->sanitizeImage($image);
                move_uploaded_file($image['image']['tmp_name'], $filename);
            }

            $db = Database::getInstance();
            $db->beginTransaction();

            $sql = "insert into products(image, title, subtitle, author, publisher, year, format, retailPrice, barcode, description) 
            values(:image, :title, :subtitle, :author, :publisher, :year, :format, :retailPrice, :barcode, :description)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'image' => $filename,
                'title' => $data['title'],
                'subtitle' => $data['subtitle'],
                'author' => $data['author'],
                'publisher' => $data['publisher'],
                'year' => $data['year'],
                'format' => $data['format'],
                'retailPrice' => $data['retailPrice'],
                'barcode' => $data['barcode'],
                'description' => $data['description'],
            ]);

            $lastInsertId = $db->lastInsertId();

            foreach ($data['categories'] as $category) {
                $sql = "insert into product_categories(products, categories) values(:id , :category)";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    'id' => $lastInsertId,
                    'category' => $category
                ]);
            }

            $sql = "insert into product_conditions(products,conditions,sellPrice,buyPrice,amount)
                   values(:id, :conditions, :sellPrice, :buyPrice, :amount)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                'id' => $lastInsertId,
                'conditions' => $data['conditions'],
                'sellPrice' => $data['sellPrice'],
                'buyPrice' => $data['buyPrice'],
                'amount' => $data['amount']
            ]);


            $db->commit();

        }catch (\PDOException $e){
            echo $e->getMessage();
            $db->rollback();
        }


    }

    public function updateAmount($productId, $conditionId, $productAmount)
    {
        $amount = $productAmount - 1;
        $conditionId = $conditionId->id;

        $db = Database::getInstance();
        $stmt = $db->prepare("update product_conditions
                    set amount = :amount
                    where products = :productId and conditions = :conditionId");
        $stmt->execute([
            'amount' => $amount,
            'productId' => $productId,
            'conditionId' => $conditionId
        ]);
    }

    public function validate($data)
    {
        $title = $data['title'];
        $subtitle = $data['subtitle'];
        $author = $data['author'];
        $publisher = $data['publisher'];
        $year = $data['year'];
        $format = $data['format'];
        $retailPrice = $data['retailPrice'];
        $barcode = $data['barcode'];
        $categories = isset($data['categories']);
        $conditions = isset($data['conditions']);
        $sellPrice = $data['sellPrice'];
        $buyPrice = $data['buyPrice'];
        $amount = $data['amount'];
        $description = $data['description'];

        if (empty($title) || empty($author) || empty($conditions) || empty($categories) || empty($sellPrice)){
            header('Location: /~polaznik22/product/create');
            return;
        }

        return $data;
    }

    public function validateImage($data)
    {
        $imageName = $data['image']['name'];
        $imageTmpName = $data['image']['tmp_name'];
        $imageSize = $data['image']['size'];
        $extension = explode('.' ,$imageName);
        $imageExtension = strtolower(end($extension));

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $imageTmpName);
        finfo_close($finfo);

        if ($imageSize > 100000){
            header('Location: /~polaznik22/product/create');
            return;
        }

        if($imageExtension != 'jpg' && $imageExtension != 'png'){
            header('Location: /~polaznik22/product/create');
            return;
        }

        if($mimeType != 'image/jpeg' && $mimeType != 'image/png'){
            header('Location: /~polaznik22/product/create');
            return;
        }

        return $data;
    }

    protected function sanitizeImage($image)
    {
        $imageName = $image['image']['name'];
        $extension = explode('.', $imageName);
        $imageExtenstion = strtolower(end($extension));

        $uploadDir = BP . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        $uploadFile = $uploadDir . uniqid('image_') . '.' . $imageExtenstion;

        return $uploadFile;
    }
}