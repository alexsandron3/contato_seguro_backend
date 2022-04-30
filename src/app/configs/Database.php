<?php

namespace Database;
class Database
{
  private $host = "localhost";
  private $database_name = "contato_seguro_desafio";
  private $username = "root";
  private $password = "@L3xsandro";
  public $conn;
  public function getConnection()
  {
    $this->conn = null;
    try {
      $this->conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
    } catch (\PDOException $exception) {
      echo "Couldnt connect to database: " . $exception->getMessage();
    }
    return $this->conn;
  }
}
