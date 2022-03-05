<?php

use PDOException;
use App\Libraries\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->connect();
    }

    public function save($data)
    {
        try {
            $query = "INSERT INTO users (name, email, verification_token, password, created_at) VALUES (:name, :email, :verification_token, :password, NOW())";
            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getAllUsers()
    {
        try {
            $query = "SELECT users.*, roles.name AS role, roles.value FROM users LEFT JOIN roles on users.role_id=roles.id";
            $statement = $this->db->query($query);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function findById($id)
    {
        try {
            $query = "SELECT users.*, roles.name AS role, roles.value FROM users LEFT JOIN roles on users.role_id=roles.id WHERE users.id=:id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ":id" => $id,
            ]);
            return $statement->fetch();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function findByEmail($email)
    {
        try {
            $query = "SELECT users.*, roles.name AS role, roles.value FROM users LEFT JOIN roles on users.role_id=roles.id WHERE users.email=:email";
            $statement = $this->db->prepare($query);
            $statement->execute([
                ":email" => $email,
            ]);

            return $statement->fetch();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function activate($user_id)
    {
        try {
            $query = "UPDATE users SET activated=1 WHERE id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
            ]);

            return $statement->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function setNullVerifyToken($user_id)
    {
        try {
            $query = "UPDATE users SET verification_token='' WHERE id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
            ]);
            
            return $statement->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function uploadPhoto($user_id, $photo)
    {
        try {
            $query = "UPDATE users SET photo=:photo WHERE id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "photo" => $photo,
            ]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function updateResetToken($user_id, $reset_password_token, $reset_token_expire)
    {
        try {
            $query = "UPDATE users SET reset_password_token=:reset_password_token, reset_token_expire=:reset_token_expire  WHERE id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "reset_password_token" => $reset_password_token,
                "reset_token_expire" => $reset_token_expire,
            ]);
            return $statement->rowCount();

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function resetPassword($user_id, $password) {
        try {
            $query = "UPDATE users SET password=:password WHERE id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "password" => $password,
            ]);
            return $statement->rowCount();

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function setNullResetToken($user_id)
    {
        try {
            $query = "UPDATE users SET reset_password_token=''  WHERE id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
            ]);
            
            return $statement->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function changePassword($user_id, $new_password) {
        try {
            $query = "UPDATE users SET password=:new_password WHERE id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "new_password" => $new_password,
            ]);
            return $statement->rowCount();

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
