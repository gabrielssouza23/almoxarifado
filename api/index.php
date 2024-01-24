<?php

ob_start();

require  __DIR__ . "/../vendor/autoload.php";

use CoffeeCode\Router\Router;

$route = new Router(url(),":");

$route->namespace("Source\App\Api");

$route->get("/user","Users:read");

$route->post("/user","Users:create");

$route->get("/user/login","Users:login");

$route->get("/itens","itensListApi:itensListApi");

$route->get("/user/list","UsersTemp:listUsers");

$route->get("/user/list/{user_id}","UsersTemp:listUserById");

$route->get("/user/update/{user_id}","Users:updateUser");

$route->post("/user/delete/{item_id}", "UsersDelete:deleteUser");

$route->get("/log/list","Logs:listLogs");

$route->get("/itens/brand/{brand_id}", "ItensListApi:listByBrand");

$route->get("/itens/brand/{brand_id}/{item_id}", "ItensListApi:listByBrandItem");

$route->post("/itens/delete/{brand_id}/{item_id}", "ItensListApi:deleteItem");

$route->post("/itens/delete/log", "Logs:deleteLog");

$route->post("/item/{item_id}","ItensListApi:updateItem");

$route->post("/item/add","ItensAdd:addItem");



$route->dispatch();




/** ERROR REDIRECT */
if ($route->error()) {
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code(404);

    echo json_encode([
        "errors" => [
            "type " => "endpoint_not_found",
            "message" => "Não foi possível processar a requisição"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

ob_end_flush();