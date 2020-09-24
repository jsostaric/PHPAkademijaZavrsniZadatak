<?php


namespace App\Core;


class DataObject
{
    protected $data = [];

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    public function __set($key, $value)
    {
        return $this->data[$key] = $value;
    }

    public function __isset($key): bool
    {
        return isset($this->data[$key]);
    }

    public function __unset($key)
    {
        unset($this->data[$key]);
        return $this;
    }

    public function __call($name, $arguments)
    {
        $key = $this->underscore(substr($name, 3));

        switch(substr($name, 0 ,3)){
            case 'get':
                return $this->__get($key);
            case 'set':
                $value = $arguments[0] ?? null;
                return $this->__set($key, $value);
            case 'has':
                return $this->__isset($key);
            case 'uns':
                return $this->__unset($key);
        }
    }

    protected function underscore($name)
    {
        return strtolower(trim(preg_replace('/([A-Z][0-9]+)/', "_$1", $name), '_'));
    }
}