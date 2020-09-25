<?php


namespace App\Model\User;

use App\Core\Database;

class UserRepository
{
    public function getUserByEmail($email)
    {
        $user = false;
        $db = Database::getInstance();

        $sql = "select * from users where email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);

        $users = $stmt->fetchAll();

        foreach ($users as $user){
            $user = new User([
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'password' => $user->password,
                'admin' => $user->admin
            ]);
        }

        return $user;
    }
}