<?php


namespace App\Model\Paydesk;


use App\Core\Database;
use App\Core\Session;

class PaydeskRepository
{
    public function getList()
    {
        $uid = Session::getInstance()->getUser()->getId();
        $list = [];

        $db = Database::getInstance();

        $sql = "select * from paydesk where users = :uid";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            'uid' => $uid
        ]);
        $result = $stmt->fetchAll();
        foreach ($result as $row){
            $list[] = new Paydesk([
               'id' => $row->id,
               'users' => $row->users,
               'products' => $row->products,
               'title' => $row->title,
               'subtitle' => $row->subtitle,
               'author' => $row->author,
               'conditions' => $row->conditions,
               'sellPrice' => $row->sellPrice,
                'amount' => $row->amount
            ]);
        }

        return $list;
    }
}