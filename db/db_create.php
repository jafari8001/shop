<?php
include "./include/config.php";
class Database{
    private $dns;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db;


    public function __construct($db_name) {
        $this->dns = DNS;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;
        $this->db_name = $db_name;

    }

    public function connect(){
        try {
            $this->db = new PDO($this->dns, $this->db_user, $this->db_pass);
            $this->db ->exec("CREATE DATABASE IF NOT EXISTS $this->db_name");
            $this->db ->exec("USE $this->db_name");

            return
                [
                    "status"=>"200",
                    "message"=> "database connecting successfuly",
                    "data"=>""

                ];

        } catch (PDOException $err) {
            return 
                [
                    "status"=>"500",
                    "message"=> $err->getMessage(),
                    "data"=>""
                ];
        }
    }

    public function create_table(){
        try {
            $this->db->exec("CREATE TABLE IF NOT EXISTS `users`(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(255) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `role` VARCHAR(255) NOT NULL
            )");
                
            $this->db->exec("CREATE TABLE IF NOT EXISTS `products` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `price` DECIMAL(10, 2) NOT NULL,
                `views` INT DEFAULT 0,
                `sales` INT DEFAULT 0,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `deleted_at` TIMESTAMP NULL
            )");
            
            $this->db->exec("CREATE TABLE IF NOT EXISTS `orders` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `product_ids` TEXT NOT NULL,
                `total_price` DECIMAL(10, 2) NOT NULL,
                `address` VARCHAR(255) NOT NULL,
                `postal_code` VARCHAR(10) NOT NULL,
                `city` VARCHAR(100) NOT NULL,
                `state` VARCHAR(100) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `deleted_at` TIMESTAMP NULL,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )");
            return [
                "status"=>"200",
                "message"=>"tables created",
                "data"=>""
            ];
        } catch (PDOException $err) {
            return [
                "status"=>"500",
                "message"=>$err->getMessage(),
                "data"=>""
            ];
        }
    }
}

?>