<?php


namespace App\Model;


use App\Core\Database;
use App\Core\DataObject;

class Model extends DataObject
{
    protected static $tableName;

    protected static function getTableName()
    {
        if (static::$tableName) {
            return static::$tableName;
        }

        throw new \Exception('$tableName property is not set.');
    }
    protected static function createObject($data)
    {
        return new static($data);
    }

    public static function getOne($column, $value)
    {
        $tableName = static::getTableName();
        $sql = "select * from {$tableName} where {$column} = :value";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute([
            'value' => $value
        ]);
        $result = $stmt->fetch() ?: [];
        return self::createObject($result);
    }

    public static function fetchAll($sql, $bind = [])
    {
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->execute($bind);
        $models = [];

        foreach ($stmt->fetchAll() as $row){
            $models = self::createObject($row);
        }

        return $models;
    }
}