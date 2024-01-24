<?php

namespace Source\App\Api;

use Source\Models\ItemAdd;
use Exception;

class ItensAdd extends Api
{
    public function __construct()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }


    public function addItem(array $data): void
    {
        // Remova o bloco if desnecessário

        if (!empty($data)) {
            // Corrija o nome da classe para ItensAdd, se necessário
            $item = new ItemAdd($data["id"], $data["addNome"], $data["addQuantidade"], $data["addPrateleira"], $data["deletado"], $data["add_id_marcas"]);

            if (!$item->addItens()) {
                $response = [
                    "error" => [
                        "code" => 400,
                        "type" => "invalid_data",
                    ]
                ];
                $this->back($response, 400);
                return;
            }

            // Remova a var_dump desnecessária

            $response = [
                "item" => [
                    "id" => $item->getId(),
                    "nome" => $item->getNome(),
                    "quantidade" => $item->getQuantidade(),
                    "localizacaoPrateleira" => $item->getLocalizacaoPrateleira(),
                    "deletado" => $item->getDeletado(),
                    "id_marcas" => $item->getIdMarcas(),
                    "type" => "success"
                ]
            ];

            $this->back($response, 201);
        }
    }
    }