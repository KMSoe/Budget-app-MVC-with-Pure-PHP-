<?php

namespace App\Libraries;

use PDO;
use PDOException;

class Database
{
    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;
    private $dbUser = DB_USER;
    private $dbPassword = DB_PASSWORD;
    private $str = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    static $database = null;
    private $db = null;
    private function __construct()
    {
        //
    }
    public static function getInstance()
    {
        if (!static::$database) {
            static::$database = new static;
        }

        return static::$database;
    }
    public function connect()
    {
        try {
            $this->db = new PDO(
                $this->str,
                $this->dbUser,
                $this->dbPassword,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );

            return $this->db;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
