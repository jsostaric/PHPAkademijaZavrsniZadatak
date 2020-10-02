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
        try {
            $db = Database::getInstance();
            $db->beginTransaction();

            $stmt = $db->prepare("insert into acquisitionProducts(products,conditions, receipt, acquisitions)
                                       values(:productId, :conditionId, :receipt, :acquisitionId)");
            $stmt->execute([
                'productId' => $productId,
                'conditionId' => $conditionId,
                'acquisitionId' => $acquisitionId,
                'receipt' => ''
            ]);

            $lastInsertedId = $db->lastInsertId();
            $receipt = $acquisitionId . '-' . $lastInsertedId;

            $stmt = $db->prepare("update acquisitionProducts set receipt = :receipt where id = :id");
            $stmt->execute([
                'id' => $lastInsertedId,
                'receipt' => $receipt
            ]);

            $db->commit();
        }catch (\PDOException $e){
            echo $e->getMessage();
            $db->rollBack();
        }
    }

    public function updateStatus($acquisitionId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("update acquisitions set completed = 1 where id = :acquisitionId");
        $stmt->execute([
           'acquisitionId' => $acquisitionId
        ]);
    }
}