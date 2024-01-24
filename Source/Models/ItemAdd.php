<?php

namespace Source\Models;

use Source\Core\Connect;
use PDO;
use PDOException;

class ItemAdd
{
    private $id;
    private $nome;
    private $quantidade;
    private $localizacao_prateleira;
    private $deletado;
    private $id_marcas;

    public function __construct(
        $id = null,
        $nome = null,
        $quantidade = null,
        $localizacao_prateleira = null,
        $deletado = null,
        $id_marcas = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->quantidade = $quantidade;
        $this->localizacao_prateleira = $localizacao_prateleira;
        $this->deletado = $deletado;
        $this->id_marcas = $id_marcas;
    }

    public function getId(): int
    {
        return intval($this->id);
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getQuantidade(): int
    {
        return intval($this->quantidade);
    }

    public function getLocalizacaoPrateleira(): string
    {
        return $this->localizacao_prateleira;
    }

    public function getDeletado(): int
    {
        return intval($this->deletado);
    }

    public function getIdMarcas(): int
    {
        return intval($this->id_marcas);
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setQuantidade(int $quantidade): void
    {
        $this->quantidade = $quantidade;
    }

    public function setLocalizacaoPrateleira(string $localizacao_prateleira): void
    {
        $this->localizacao_prateleira = $localizacao_prateleira;
    }

    public function setDeletado(int $deletado): void
    {
        $this->deletado = $deletado;
    }

    public function setIdMarcas(int $id_marcas): void
    {
        $this->id_marcas = $id_marcas;
    }

    public function addItens()
    {

        $query = "INSERT INTO itens_estoque ( nome, quantidade, localizacao_prateleira, deletado, id_marcas)
                  VALUES ( :nome, :quantidade, :localizacao_prateleira, :deletado, :id_marcas)";


        $stmt = Connect::getInstance()->prepare($query);
        // $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':quantidade', $this->quantidade);
        $stmt->bindParam(':localizacao_prateleira', $this->localizacao_prateleira);
        $stmt->bindValue(':deletado', 0);
        $stmt->bindParam(':id_marcas', $this->id_marcas);

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
