<?php

namespace Source\App;

use League\Plates\Engine;

class Web
{

    private $view;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . "/../../themes/web", "php");
    }
    public function home()
    {
        echo $this->view->render("home");
    }

    // public function register(array $data)
    // {
    //     if(!empty($data)){
    //         $response = json_encode($data);
    //         echo $response;
    //         return;
    //     }

    //     echo $this->view->render("register-clean",[
    //        // "categories" => $this->categories
    //     ]);
    // }

    public function login(array $data): void
    {
        echo $this->view->render("user-auth", []);
    }

    public function register(array $data): void
    {
        echo $this->view->render("register", []);
    }

    public function apiLogin(): void
    {
        echo $this->view->render("api-login", []);
    }
}
