<?php


namespace App\Model\Acquisition;


use App\Core\Database;
use App\Core\Session;

class AcquisitionCartResource
{
    public function insertInCart($data)
    {
        $productId = $data->id;
        $conditionId = $data->conditionId;
        $uid = Session::getInstance()->getUser()->getId();

        $db = Database::getInstance();

        $sql = "insert into acquisitionCart(users,products, conditions) 
                    values(:uid, :productId, :conditionId)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'uid' => $uid,
            'productId' => $productId,
            'conditionId' => $conditionId
        ]);
    }

    public function removeItem($data)
    {
        $itemId = $data->id;

        $db = Database::getInstance();
        $stmt = $db->prepare("delete from acquisitionCart where id = :itemId");
        $stmt->execute([
            'itemId' => $itemId
        ]);
    }

    public function clearCart()
    {
        $uid = Session::getInstance()->getUser()->getId();
        $db = Database::getInstance();
        $stmt = $db->prepare("delete from acquisitionCart where users = :uid");
        $stmt->execute([
            'uid' => $uid
        ]);
    }
}