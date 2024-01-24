<?php

namespace Source\Models;

use Source\Core\Connect;
use PDO;
use PDOException;

class ItensLog
{
    private $id;
    private $id_item;
    private $id_usuario;
    private $data_hora;


    public function __construct(
        $id = null,
        $id_item = null,
        $id_usuario = null,
        $data_hora = null
    ) {
        $this->id = $id;
        $this->id_item = $id_item;
        $this->id_usuario = $id_usuario;
        $this->data_hora = $data_hora;
    }

    public function getId(): int
    {
        return intval($this->id);
    }

    
    public function getIdItem(): int
    {
        return $this->id_item;
    }

    public function getIdUsuario(): int
    {
        return $this->id_usuario;
    }

    public function getDataHora(): string
    {
        return $this->data_hora;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function setIdItem(int $id_item): void
    {
        $this->id_item = $id_item;
    }

    public function setIdUsuario(int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function setDataHora(string $data_hora): void
    {
        $this->data_hora = $data_hora;
    }

    public function selectAllLogs()
    {
        $query = "
        SELECT 
        il.id,
        il.id_item,
        il.data_hora_exclusao,
        i.nome AS item_nome,
        i.quantidade AS item_quantidade,
        i.localizacao_prateleira AS item_localizacao,
        u.nome AS usuario_nome,
        u.email as usuario_email
    FROM
        logs_exclusao il
    JOIN
        usuarios u ON il.id_usuario = u.id
    JOIN
        itens_estoque i ON il.id_item = i.id;
        ";

        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }




    public function selectByBrand(string $brandName)
    {
        $query = "SELECT
            i.id,
            i.nome,
            i.quantidade,
            i.localizacao_prateleira,
            i.deletado,
            m.nome AS marca
    FROM
        itens_estoque i
    JOIN
        marcas m ON i.id_marcas = m.id
    WHERE
        m.nome LIKE '{$brandName}';
    ";
        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    public function selectById(int $id)
    {
        $query = "SELECT
        i.id,
        i.nome,
        i.quantidade,
        i.localizacao_prateleira,
        i.deletado,
        m.nome AS marca,
        m.id AS id_marca
    FROM
        itens_estoque i
    JOIN
        marcas m ON i.id_marcas = m.id
    WHERE
        m.id LIKE '{$id}';
        ";

        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    public function selectByCategoryId(int $categoryId)
    {
        $query = "SELECT
            i.id,
            i.nome,
            i.quantidade,
            i.localizacao_prateleira,
            i.deletado,
            m.nome AS marca,
            m.id AS id_marca
        FROM
            itens_estoque i
        JOIN
            marcas m ON i.id_marcas = m.id
        WHERE
            m.id LIKE '{$categoryId}';
    ";
        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    public function selectByCategoryIdItem(int $itemId)
    {
        $query = "SELECT
            i.id,
            i.nome,
            i.quantidade,
            i.localizacao_prateleira,
            i.deletado,
            m.nome AS marca,
            m.id AS id_marca
        FROM
            itens_estoque i
        JOIN
            marcas m ON i.id_marcas = m.id
        WHERE
            i.id = {$itemId};
    ";
        $stmt = Connect::getInstance()->query($query);
        return $stmt->fetchAll();
    }

    


    public function deleteItemLog()
    {
        $query = "INSERT INTO logs_exclusao (
            id_item,
            id_usuario,
            data_hora_exclusao
        ) VALUES (
            :id_item,
            :id_usuario,
            :data_hora_exclusao
        )";
        
        

        $stmt = Connect::getInstance()->prepare($query);
        //$stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_item', $this->id_item);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':data_hora_exclusao', $this->data_hora);

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
