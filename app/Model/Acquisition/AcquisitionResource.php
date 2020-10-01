<?php


namespace App\Model\Acquisition;

use App\Core\Database;
use App\Core\Session;

class AcquisitionResource
{
    public function insert($total)
    {
        $uid = Session::getInstance()->getUser()->getId();

        $db = Database::getInstance();
        $stmt = $db->prepare("insert into acquisitions(users, total) values(:uid, :total)");
        $stmt->execute([
            'uid' => $uid,
            'total' => $total
        ]);

        $lastInsertedId = $db->lastInsertId();
        return $lastInsertedId;
    }

    public function insertInAcquired($data, $acquisitionId)
    {

        $productId = $data->products;
        $conditionId = $data->conditions;

        $db = Database::getInstance();
        $stmt = $db->prepare("insert into acquisitionProducts(products,conditions,acquisitions)
                                       values(:productId, :conditionId, :acquisitionId)");
        $stmt->execute([
            'productId' => $productId,
            'conditionId' => $conditionId,
            'acquisitionId' => $acquisitionId
        ]);
    }
}