<?php


namespace App\Model\Acquisition;

use App\Core\Database;
use App\Core\Session;

class AcquisitionCartRepository
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
        $uid = Session::getInstance()->getUser()->getId();
        $list = [];

        $db = Database::getInstance();

        $stmt = $db->prepare("select * from acquisitionCart where users = :uid");
        $stmt->execute([
            'uid' => $uid
        ]);
        $result = $stmt->fetchAll();
        foreach ($result as $row){
            $list[] = new Acquisition([
                'id' => $row->id,
                'uid' => $row->users,
                'products' => $row->products,
                'conditions' => $row->conditions
            ]);
        }

        return $list;
    }

    public function getItemInCartId($itemId, $conditionId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("select id from acquisitionCart where products = :itemId and conditions = :conditionId");
        $stmt->execute([
           'itemId' => $itemId,
           'conditionId' => $conditionId
        ]);
        return $stmt->fetch();
    }
}