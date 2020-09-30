<?php


namespace App\Model\Paydesk;


use App\Core\Database;

class PaydeskRepository
{
    public function getList()
    {
        $list = [];

        $db = Database::getInstance();

        $sql = "select * from paydesk";

        $stmt = $db->prepare($sql);
        $stmt->execute();
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