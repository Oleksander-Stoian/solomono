<?php
require_once 'db.php';

class Category {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllCategories() {
        $query = "SELECT c.id, c.name, COUNT(p.id) AS product_count 
                  FROM categories c 
                  LEFT JOIN products p ON c.id = p.category_id 
                  GROUP BY c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
