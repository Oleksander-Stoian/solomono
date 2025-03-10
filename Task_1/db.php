<?php
class Database {
    private $host = "localhost";
    private $dbname = "solomono";
    private $username = "root";
    private $password = "";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Помилка підключення до бази даних: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
