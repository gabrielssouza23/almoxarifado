<?php

namespace Source\Models;

use Source\Core\Connect;
use Source\themes\app\stock;

class Marcas
{

    public function selectAll()
    {
        $query = "SELECT * FROM marcas";
        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

}