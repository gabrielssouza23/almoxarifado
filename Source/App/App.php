<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\Marcas;

class App
{

    private $view;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . "/../../themes/app", "php");
    }
    public function home()
    {
        echo $this->view->render("home");
    }

    public function stock(array $data)
    {
        $marcas = new Marcas();
        echo $this->view->render("stock", [
            "marcas" => $marcas->selectAll()
        ]);
    }

    public function logDelete(array $data)
    {
        echo $this->view->render("logDelete", []);
    }

    public function login(array $data): void
    {
        echo $this->view->render("user-auth", []);
    }

    public function register(array $data): void
    {
        echo $this->view->render("register", []);
    }
}
