<?php
    include "include/Database.php";
    $database = new Database("shop");
    $response = $database->connect();
    $response_2 = $database->create_table();
    echo json_encode($response);
    echo json_encode($response_2);

?>