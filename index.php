<?php

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

ob_start();

$route = new Router(url(), ":");

$route->namespace("Source\App");

$route->get("/registro","Web:register");

$route->group(null);

$route->get("/", "Web:home");
$route->get("/estoque", "App:stock");
$route->get("/logs", "App:logDelete");
$route->get("/api-login","Web:apiLogin");

$route->get("/usuarios", "Adm:userPanel");
$route->group(null);




$route->dispatch();

if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
