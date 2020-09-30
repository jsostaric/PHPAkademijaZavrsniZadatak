<?php


namespace App\Model\Acquisition;


use App\Core\Database;

class AcquisitionResource
{
    public function insertInCart($data)
    {
        $productId = $data->id;
        $conditionId = $data->conditionId;

        $db = Database::getInstance();

        $sql = "insert into acquisitionCart(products, conditions) 
                    values(:productId, :conditionId)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'productId' => $productId,
            'conditionId' => $conditionId
        ]);
    }

    public function removeItem($data)
    {
        $itemId = $data;

        $db = Database::getInstance();
        $stmt = $db->prepare("delete from acquisitionCart where products = :itemId");
        $stmt->execute([
            'itemId' => $itemId
        ]);
    }
}