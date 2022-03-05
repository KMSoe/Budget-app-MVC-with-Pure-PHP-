<?php

use PDOException;
use App\Libraries\Database;

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->connect();
    }
    public function save($data) {
        try {
            $query = "INSERT INTO categories(name, icon_id, type, user_id, created_at) values(:name, :icon_id, :type, :user_id, NOW())";
            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function saveIcon($data) {
        try {
            $query = "insert into icons(class, color, created_at) values(:class, :color, NOW())";
            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getCategories($user_id) {
        try {    
            $query = "SELECT categories.*, icons.class, icons.color FROM categories LEFT JOIN icons ON categories.icon_id=icons.id WHERE categories.user_id=:admin_id or categories.user_id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "admin_id" => 1,
                "user_id" => $user_id,
            ]);
            
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getCategoryIconColor($category_id) {
        try {    
            $query = "SELECT categories.*, icons.class, icons.color FROM categories LEFT JOIN icons ON categories.icon_id=icons.id WHERE categories.id=:category_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "category_id" => $category_id,
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getIconColor($category_id) {
        try {    
            $query = "SELECT categories.icon_id, icons.class, icons.color FROM categories LEFT JOIN icons ON categories.icon_id=icons.id WHERE categories.id=:category_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "category_id" => $category_id,
            ]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getIcons() {
        try {    
            $query = "SELECT * FROM icons WHERE id NOT IN (SELECT icon_id FROM categories LEFT JOIN icons on categories.icon_id=icons.id)";
            $statement = $this->db->query($query);
            
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getByUserId($user_id) {
        try {
            
            $query = "SELECT * FROM categories WHERE user_id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
            ]);
            
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
  
    public function delete($id, $user_id) {
        try {
            $query = "DELETE FROM categories WHERE id=:id AND user_id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "id" => $id,
                "user_id" => $user_id,
            ]);
            
            return $statement->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}