<?php
class User{
    private $connection;

    public function __construct($db_name) {
        include "./include/Database.php";
        $db = new Database($db_name);
        $this->connection = $db->connect();
        $this->connection ->exec("USE $db_name");
    }    

    public function registerUser($data){
        if (
            !isset($data['username']) || empty($data['username']) ||
            !isset($data['name']) || empty($data['name']) ||
            !isset($data['email']) || empty($data['email']) ||
            !isset($data['password']) || empty($data['password']) ||
            !isset($data['role']) || empty($data['role'])
        ) {
            return [
                "status" => "400",
                "message" => "Fill in all fields",
                "data" => ""
            ];
        }else {
            $username = $data['username'];
            $name = $data['name'];
            $email = $data['email'];
            $password = $data['password'];
            $role = $data['role'];
        }

        if ($this->userExists($username)) {
            return [
                "status" => "409",
                "message" => "This Username is exist",
                "data" => ""
            ];
        }else {
            $query = "INSERT INTO `users` (`username`, `name`, `email`, `password`, `role`) VALUES (:username, :name, :email, :password, :role)";
            $db = $this->connection->prepare($query);
            $db->execute([
                "username" => $username,
                "name" => $name,
                "email" => $email,
                "password" => $password,
                "role" => $role
            ]);
    
            return [
                "status" => "209",
                "message" => "User added",
                "data" => [
                    "username" => $username,
                    "name" => $name,
                    "email" => $email,
                    "password" => $password,
                    "role" => $role
                ]
            ];
        }  
    }

    public function userExists($username){

        $query = "SELECT * FROM `users` WHERE username = :username";
        $check = $this->connection->prepare($query);
        $check->execute(["username"=> $username]);
        if ($check->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
