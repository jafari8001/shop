<?php

include "./router/Router.php";
$router = new Router();

$router->addRoute('', function () {
    echo json_encode("Home");
});

$router->addRoute('create-database', function () {
    include "router/database.php";
});

$router->addRoute('add-user', function () {
    include "./router/add_user.php";
});

$router->addRoute('contact', function () {
    echo 'تماس با ما';
});

$url = $_SERVER['REQUEST_URI'];
$router->dispatch($url);


?>