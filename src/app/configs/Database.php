<?php

namespace App\Database;

include_once '../../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
class Database
{
  public $conn;
  public function getConnection()
  {
    $this->conn = null;
    try {
      $this->conn = new \PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    } catch (\PDOException $exception) {
      echo "Couldnt connect to database: " . $exception->getMessage();
    }
    return $this->conn;
  }
}
