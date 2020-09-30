<?php


namespace App\Model\Condition;


use App\Core\Database;

class ConditionRepository
{
    public function getId($productCondition)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("select id from conditions where name = :name");
        $stmt->execute([
            'name' => $productCondition
        ]);

        return $conditionId = $stmt->fetch();
    }
}