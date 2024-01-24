<?php

namespace Source\App\Api;

use Source\Models\User;

class UsersTemp extends Api
{
    public function __construct()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }

    public function listUsers (array $data) : void
    {
        $users = (new User())->selectAllUsers();
        $this->back($users,200);
    }
   
    // public function listUserById (array $data) : void
    // {
    //     $user = (new User())->selectUserById($data["user_id"], $data["nome"], $data["email"], $data["isAdmin"], $data["isActive"]);
    //     $response = [
    //         "user" => [
    //             "id" => $user->getId(),
    //             "nome" => $user->getName(),
    //             "email" => $user->getEmail(),
    //             "isAdmin" => $user->getIsAdmin(),
    //             "isActive" => $user->getIsActive(),
    //             "type" => "success"

    //         ]
    //     ];

    //     $this->back($response, 201);
    // }
}