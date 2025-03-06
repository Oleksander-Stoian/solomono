<?php
require_once 'db.php';

class Product {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getProducts($category = null, $sort = 'date_desc') {
        $sortQuery = "ORDER BY ";
        switch ($sort) {
            case 'name_asc':
                $sortQuery .= "name ASC";
                break;
            case 'date_desc':
                $sortQuery .= "created_at DESC";
                break;
            default:
                $sortQuery .= "price ASC";
        }

        $query = "SELECT * FROM products";
        if ($category) {
            $query .= " WHERE category_id = :category";
        }
        $query .= " " . $sortQuery;

        $stmt = $this->conn->prepare($query);
        if ($category) {
            $stmt->bindParam(":category", $category, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
