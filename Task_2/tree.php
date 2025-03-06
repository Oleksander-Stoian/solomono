<?php
require_once 'db.php';

class CategoryTree {
    private $conn;
    

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
	
	// Метод для отримання підключення до БД (для index.php)
    public function getConnection() {
        return $this->conn;
    }
	
     public function buildTree() {
        // 🔹 Виконуємо SQL-запит (без кешування)
        $query = "SELECT categories_id AS id, parent_id FROM categories ORDER BY parent_id, categories_id";
        $stmt = $this->conn->prepare($query);

        if (!$stmt->execute()) {
            return ["error" => "Database query failed"];
        }

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$categories) {
            return ["error" => "No categories found in the database"];
        }

        $tree = [];
        $references = [];

        // 🔹 Один цикл для заповнення всіх категорій та їхнього зв’язку з батьківськими
        foreach ($categories as $category) {
            $references[$category['id']] = $references[$category['id']] ?? []; // Ініціалізація
            if (!is_null($category['parent_id']) && $category['parent_id'] != 0) {
                $references[$category['parent_id']][$category['id']] = &$references[$category['id']];
            } else {
                $tree[$category['id']] = &$references[$category['id']]; // Це кореневий елемент
            }
        }

        // 🔹 Заповнюємо кінцеві вузли їхніми ж ID (без рекурсії)
        foreach ($references as $id => &$subcategories) {
            if (empty($subcategories)) {
                $subcategories = $id;
            }
        }

        return $tree;
    }

    public function getTree() {
        return $this->buildTree();
    }
}
