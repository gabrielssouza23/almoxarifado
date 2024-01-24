<?php

namespace Source\App\Api;

use Exception;

use Source\Models\User;

class Users extends Api
{
    public function __construct()
    {
        parent::__construct();
    }

    public function read (array $data) : void
    {
        $response = [
            "code" => 200,
            "type" => "success",
            "message" => "Dados do usuário"
        ];
        http_response_code(200);
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function create (array $data) : void
    {
       if(!empty($data)){
        $user = new User($data["name"], $data["email"], $data["password"], $data["isAdmin"]);
        if(!$user->insert()){
                $response = [
                    "error" => [
                        "code" => 400,
                        "type" => "invalid_data",
                        "message" => $user->getMessage()
                    ]
                ];
                $this->back($response,400);
                return;
            }

            $response = [
                "user" => [
                    "id" => $user->getId(),
                    "name" => $user->getName(),
                    "email" => $user->getEmail(),
                    "token" => $this->token

                ]
            ];

            $this->back($response,201);
        }
    
    }

    public function login (array $data) : void
    {
            if(!empty($this->token)){
                $response = [
                    "user" => [
                        "id" => $this->user->getId(),
                        "name" => $this->user->getName(),
                        "email" => $this->user->getEmail(),
                        "isAdmin" => $this->user->getIsAdmin(),
                        "isActive" => $this->user->getIsActive(),
                        "token" => $this->token,
                        "type" => "success"
                ]
                ];
                $this->back($response,200);
            }
           // else{$this->back(["type" => "error"],400);}

        

    }
   

    public function updateUser (array $data) : void
    {
        if(!empty($data)){
            $user = new User($data["id"], $data["inputNome"], $data["inputEmail"], $data["inputIsAdmin"], $data["isActive"]);
            if(!$user->updateUser()){
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
    
                $response = [
                    "user" => [
                        "id" => $user->getId(),
                        "nome" => $user->getName(),
                        "email" => $user->getEmail(),
                        "isAdmin" => $user->getIsAdmin(),
                        "isActive" => $user->getIsActive(),
                        "type" => "success"
    
                    ]
                ];
    
                $this->back($response,201);
            }
           // else{$this->back(["type" => "error"],400);}
    }
}