<?php


namespace App\Model\Paydesk;


use App\Core\Database;
use App\Core\Session;

class PaydeskResource
{
    public function insert($data)
    {
        $productId = $data->id;
        $title = $data->title;
        $subtitle = $data->subtitle;
        $author = $data->author;
        $conditions = $data->conditions;
        $sellPrice = $data->sellPrice;
        $amount = $data->amount;
        $uid = Session::getInstance()->getUser()->getId();

        $db = Database::getInstance();

        $sql = "insert into paydesk(users,products, title, subtitle, author, conditions, sellPrice, amount) 
                    values(:uid, :productId, :title, :subtitle, :author, :conditions, :sellPrice, :amount)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
           'uid' => $uid,
           'productId' => $productId,
            'title' => $title,
            'subtitle' => $subtitle,
            'author' => $author,
            'conditions' => $conditions,
            'sellPrice' => $sellPrice,
            'amount' => $amount
        ]);
    }

    public function removeItem($data)
    {
        $itemId = $data;

        $db = Database::getInstance();
        $stmt = $db->prepare("delete from paydesk where id = :itemId");
        $stmt->execute([
           'itemId' => $itemId
        ]);
    }

    public function clearPaydesk()
    {
        $uid = Session::getInstance()->getUser()->getId();
        $db = Database::getInstance();
        $stmt = $db->prepare("delete from paydesk where users = :uid");
        $stmt->execute([
            'uid' => $uid
        ]);
    }
}