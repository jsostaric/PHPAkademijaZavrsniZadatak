<?php


namespace App\Model\Category;


use App\Core\Database;

class CategoryRepository
{
    public function getList($type)
    {
        $list = [];
        $db = Database::getInstance();
        $stmt = $db->prepare('select * from categories where typeOfCat = :type');
        $stmt->execute([
            'type' => $type
        ]);

        foreach ($stmt->fetchAll() as $category){
            $list[] = new Category([
                'id' => $category->id,
                'name' => $category->name
            ]);
        }

        return $list;
    }
}