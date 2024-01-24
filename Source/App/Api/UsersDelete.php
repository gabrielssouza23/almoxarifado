<?php

namespace Source\App\Api;

use Exception;

use Source\Models\UserDelete;

class UsersDelete extends Api
{
    public function __construct()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }

   
    public function deleteUser (array $data) : void
    {
        if(!empty($data)){
            $user = new UserDelete($data["id"], $data["isActive"]);
            if(!$user->deleteUser()){
                    $response = [
                        "error" => [
                            "code" => 400,
                            "type" => "invalid_data",
                            // "message" => $item->getMessage()
                        ]
                    ];
                    $this->back($response,400);
                    return;
                }
    
            var_dump($user);
                $response = [
                    "user" => [
                        "id" => $user->getId(),
                        "isActive" => $user->getIsActive(),
                        "type" => "success"
    
                    ]
                ];
                
                $this->back($response,201);
            }
           // else{$this->back(["type" => "error"],400);}

        

    }
}