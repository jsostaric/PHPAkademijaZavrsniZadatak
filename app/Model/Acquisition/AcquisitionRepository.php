<?php


namespace App\Model\Acquisition;


use App\Core\Database;

class AcquisitionRepository
{
    public function getList()
    {
        $list = [];

        $db = Database::getInstance();

        $stmt = $db->prepare("select * from acquisitions order by dateOfEntry desc");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row){
            $list[] = new Acquisition([
               'id' => $row->id,
               'users' => $row->users,
               'total' => $row->total,
                'dateOfEntry' => $row->dateOfEntry
            ]);
        }

        return $list;
    }

    public function getAcquisitions($term)
    {
        $term = trim($term);
        $term = "%{$term}%";

        $db = Database::getInstance();

        $stmt = $db->prepare("select * from acquisitions where id like :term order by id desc");
        $stmt->execute([
            'term' => $term
        ]);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAcquired($acquisitionId)
    {
        $list = [];
        $db = Database::getInstance();
        $stmt = $db->prepare("select * from acquisitionProducts where acquisitions = :id");
        $stmt->execute([
           'id' => $acquisitionId
        ]);
        foreach ($stmt->fetchAll() as $row){
            $list[] = new Acquisition([
               'id' => $row->id,
               'products' =>$row->products,
               'conditions' =>$row->conditions,
            ]);
        }

        return $list;
    }
}