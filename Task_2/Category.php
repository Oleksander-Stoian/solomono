<?php 
require_once 'db.php';

class Category {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllCategories() {
        $query = "SELECT categories_id, parent_id FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buildTree($categories) {
        $tree = [];
        $categoriesById = [];

        // Створюємо хеш-мапу категорій
        foreach ($categories as $category) {
            $categoriesById[$category['categories_id']] = []; 
        }

        // Заповнюємо дерево
        foreach ($categories as $category) {
            if ($category['parent_id'] == 0) {
                $tree[$category['categories_id']] = &$categoriesById[$category['categories_id']];
            } else {
                if (isset($categoriesById[$category['parent_id']])) {
                    $categoriesById[$category['parent_id']][$category['categories_id']] = &$categoriesById[$category['categories_id']];
                }
            }
        }

        return $tree;
    }
    
    // Робимо метод частиною класу
    private function simplifyTree(&$tree) {
        foreach ($tree as $key => &$value) {
            if (empty($value)) {
                $value = $key; // Замінюємо порожні масиви на ID
            } else {
                $this->simplifyTree($value); // Рекурсія для вкладених елементів
            }
        }
    }

    public function getCategoryTree() {
        $categories = $this->getAllCategories();
        $tree = $this->buildTree($categories);
        $this->simplifyTree($tree); // Викликаємо метод для очищення порожніх масивів
        return $tree;
    }
}
?>
