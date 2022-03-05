<?php

namespace App\Libraries;

use PDO;
use PDOException;

class Populate
{
    public function __construct()
    {
        $this->db = Database::getInstance()->connect();
        $this->createTables();
        $this->insertRoleData();
        $this->insertIconData();
        // $this->dropTables();
    }

    public function createTables()
    {
        $query = "CREATE TABLE IF NOT EXISTS roles (id int PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL, value int NOT NULL)";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS users (id int PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL,verification_token VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, reset_password_token VARCHAR(255), reset_token_expire VARCHAR(255), role_id int DEFAULT 1, photo VARCHAR(255), activated int DEFAULT 0,suspended int DEFAULT 0, total_income DECIMAL DEFAULT 0.0, total_expense DECIMAL DEFAULT 0.0, created_at DATETIME, updated_at DATETIME DEFAULT NOW(), foreign key(role_id) references roles(id))";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS icons (id int PRIMARY KEY AUTO_INCREMENT, class VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL,  created_at DATETIME, updated_at DATETIME DEFAULT NOW())";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS categories (id int PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL, icon_id int, type varchar(10) NOT NULL, user_id int, created_at DATETIME, updated_at DATETIME DEFAULT NOW(), foreign key(user_id) references users(id), foreign key(icon_id) references icons(id))";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS budget_items (id int PRIMARY KEY AUTO_INCREMENT, category_id int NOT NULL, remark VARCHAR(255), type VARCHAR(10) NOT NULL, amount DECIMAL NOT NULL, user_id int NOT NULL, created_at DATETIME, updated_at DATETIME DEFAULT NOW(), foreign key(user_id) references users(id), foreign key(category_id) references categories(id))";
        $this->db->query($query);
    }
    public function insertRoleData()
    {
        $roles = [
            ["name" => "user", "value" => 1],
            ["name" => "admin", "value" => 2],
        ];
        $results = $this->db->query("SELECT * FROM roles")->fetchAll();
        $len = count($results);
        if ($len === 0) {
            foreach ($roles as $data) {
                try {
                    $query = "INSERT INTO roles (name, value) VALUES (:name, :value)";
                    $statement = $this->db->prepare($query);
                    $statement->execute($data);

                    $this->db->lastInsertId();
                } catch (PDOException $e) {
                    return $e->getMessage();
                }
            }
        }
    }
    public function insertIconData()
    {
        $icons = [
            ["class" => "fas fa-utensils", "color" => "#e7ab3c"],
            ["class" => "fas fa-home", "color" => "#0068b2"],
            ["class" => "fas fa-glass-martini-alt", "color" => "#b7a8a3"],
            ["class" => "fas fa-tshirt", "color" => "#085719"],
            ["class" => "fas fa-shopping-cart", "color" => "#b63333"],
            ["class" => "fas fa-plane-departure", "color" => "#0fe73e"],
            ["class" => "fas fa-bus", "color" => "#d2f50a"],
            ["class" => "fas fa-graduation-cap", "color" => "#e7ab3c"],
            ["class" => "fas fa-dollar-sign", "color" => "#85bb65"],
            ["class" => "fas fa-file-invoice-dollar", "color" => "#4e575c"],
            ["class" => "fas fa-first-aid", "color" => "#e41809"],
            ["class" => "fas fa-soap", "color" => "#866b8d"],
            ["class" => "fas fa-dollar-sign", "color" => "#e33010"],
            ["class" => "fas fa-chalkboard-teacher", "color" => "#e7ab3c"],
            ["class" => "fas fa-chart-area", "color" => "#0dd427"],
            ["class" => "fab fa-get-pocket", "color" => "#e7ab3c"],
            ["class" => "fab fa-get-sellcast", "color" => "#e43a36"],
        ];
        $results = $this->db->query("SELECT * FROM icons")->fetchAll();
        $len = count($results);

        if ($len === 0) {
            foreach ($icons as $data) {
                try {
                    $query = "INSERT into icons(class, color, created_at) values(:class, :color, NOW());";
                    $statement = $this->db->prepare($query);
                    $statement->execute($data);

                    $this->db->lastInsertId();
                } catch (PDOException $e) {
                    return $e->getMessage();
                }
            }
        }
    }
    public function dropTables()
    {
        $query = "DROP table budget_items";
        $this->db->query($query);

        $query = "DROP table categories";
        $this->db->query($query);

        $query = "DROP table icons";
        $this->db->query($query);

        $query = "DROP table users";
        $this->db->query($query);

        $query = "DROP table roles";
        $this->db->query($query);
    }
}
