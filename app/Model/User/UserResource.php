<?php


namespace App\Model\User;


use App\Core\Database;

class UserResource
{
    public function insertUser($data)
    {
        $pass = password_hash($data['password'], PASSWORD_DEFAULT);

        $db = Database::getInstance();
        $sql = "insert into users(username, email, password) values(:username, :email, :password)";

        $statement = $db->prepare($sql);
        $result = $statement->execute([
           'username' => $data['username'],
           'email' => $data['email'],
           'password' => $pass
        ]);

        return $result;
    }
}