<?php

namespace Source\App\Api;

use Exception;
use Source\Models\ItensDelete;
use Source\Models\ItensLog;

class Logs extends Api
{
    public function __construct()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }

    public function listLogs(array $data): void
    {
        $logs = (new ItensLog())->selectAllLogs();
        $this->back($logs, 200);
    }

    public function deleteLog(array $data): void
    {
       if(!empty($data)){
        $log = new ItensLog($data["id"], $data["id_item"], $data["id_usuario"], $data["data_hora_exclusao"]);
        if(!$log->deleteItemLog()){
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
                    "id" => $log->getId(),
                    "type" => "success"

                ]
            ];

            $this->back($response,201);
        }
    }

}
