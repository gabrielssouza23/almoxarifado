<?php

namespace Source\App\Api;

use Source\Models\Itens;
use Exception;
use Source\Models\ItensDelete;

class ItensListApi extends Api
{
    public function __construct()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }

    public function itensListApi(array $data): void
    {
        $itens = (new Itens())->selectAllItens();
        $this->back($itens, 200);
    }



    public function listByBrand(array $data): void
    {
        $itens = (new Itens())->selectById($data["brand_id"]);
        $this->back($itens, 200);
    }

    public function listByBrandItem(array $data): void
    {
        $itens = (new Itens())->selectByCategoryIdItem($data["item_id"]);
        $this->back($itens, 200);
    }

    public function deleteItem(array $data): void
    {
        if (!empty($data)) {
            $item = new ItensDelete($data["id"], $data["deletado"]);
            var_dump($item);
            if (!$item->deleteItem()) {
                $response = [
                    "error" => [
                        "code" => 400,
                        "type" => "invalid_data",
                        // "message" => $item->getMessage()
                    ]
                ];
                $this->back($response, 400);
                return;
            }

            $response = [
                "user" => [
                    "id" => $item->getId(),
                    "deletado" => $item->getDeletado(),
                    "type" => "success"

                ]
            ];

            $this->back($response, 201);
        }
    }

    public function updateItem(array $data): void
    {
        // Certifique-se de ajustar os nomes dos campos conforme necessário
        if (!empty($data)) {
            $item = new Itens($data["id"], $data["inputNome"], $data["inputQuantidade"], $data["inputPrateleira"], $data["deletado"], $data["id_marcas"]);
           // var_dump($item);
            if (!$item->updateItemById()) {
                $response = [
                    "error" => [
                        "code" => 400,
                        "type" => "invalid_data",
                        // "message" => $item->getMessage()
                    ]
                ];
                $this->back($response, 400);
                return;
            }

            $response = [
                "user" => [
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
