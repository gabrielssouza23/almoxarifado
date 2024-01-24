<?php

namespace Source\Models;

use Source\Core\Connect;
use PDO;
use PDOException;
use Source\App\Api\Api;

class ItensDelete
{
    private $id;
    private $deletado;

    public function __construct(
        $id = null,
        $deletado = null
    ) {
        $this->id = $id;
        $this->deletado = $deletado;
    }

    public function getId(): int
    {
        return intval($this->id);
    }

    public function getDeletado(): int
    {
        return intval($this->deletado);

    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setDeletado(int $deletado): void
    {
        $this->deletado = $deletado;
    }
   

    public function deleteItem()
    {
        $query = "UPDATE itens_estoque SET
        deletado = :deletado
        WHERE id = :id";

        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':deletado', $this->deletado);

        try {
            $stmt->execute();
            return true; // Retorna true se a execução for bem-sucedida
        } catch (PDOException $e) {
            // Trate qualquer exceção gerada durante a execução da consulta
            // Você pode fazer log do erro ou lidar de outra maneira adequada ao seu aplicativo
            return false;
        }
    }
}