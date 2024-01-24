<?php

namespace Source\App;

use League\Plates\Engine;



class Adm
{
    private $view;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . "/../../themes/adm", "php");
    }

    public function userPanel(array $data): void
    {
        echo $this->view->render("userPanel", []);
    }

   
}
