<?php


namespace App\Model\User;

use App\Core\Database;
use App\Core\Session;

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

    public function getUserById($uid)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("select * from users where id = :uid");

        $stmt->execute([
           'uid' => $uid
        ]);

        return $stmt->fetch();
    }

    public function passwordCheck($data)
    {
        $message = '';
        $oldPassword = $data['oldPassword'];
        $password = $data['password'];
        $confirmPassword = $data['confirmPassword'];

        if (empty($oldPassword) || empty($password) || empty($confirmPassword)) {
            return  $message = 'All fields must be filled';
        }

        if(!password_verify($oldPassword, Session::getInstance()->getUser()->getPassword())) {
            return  $message = 'Old password does not match';
        }

        if(password_verify($password, Session::getInstance()->getUser()->getPassword())) {
            return  $message = 'New password cannot be same as old';
        }

        if($password != $confirmPassword) {
            return  $message = 'Please repeat password correctly';
        }

        return $message;
    }
}