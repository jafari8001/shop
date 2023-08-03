<?php
include "./include/User.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $inputJSON = file_get_contents('php://input');
    $data = json_decode($inputJSON, true);
    $new_user = new User('shop');
    echo json_encode($new_user ->registerUser($data));
    
}else {
    echo json_decode("data is not set");
}
?>