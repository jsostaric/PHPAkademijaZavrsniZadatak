<?php


namespace App\Model\Acquisition;

use App\Core\Database;

class AcquisitionRepository
{
    public function getList()
    {
        $list = [];

        $db = Database::getInstance();

        $sql = "select * from acquisitionCart where products = :productsId and conditions = :conditionId";

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row){
            $list[] = new Acquisition([
                'id' => $row->id,
            ]);
        }

        return $list;
    }

    public function getFromCart()
    {
        $list = [];

        $db = Database::getInstance();

        $stmt = $db->prepare("select * from acquisitionCart");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row){
            $list[] = new Acquisition([
                'id' => $row->id,
                'products' => $row->products,
                'conditions' => $row->conditions
            ]);
        }

        return $list;
    }
}