<?php
require_once 'tree.php';

header('Content-Type: application/json');

function getTableStructure($conn) {
    $query = "DESCRIBE categories";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Вимірюємо час початку виконання скрипта
$startTime = microtime(true);

// Отримуємо дерево категорій
$categoryTree = new CategoryTree();
$response = [
    "table_structure" => getTableStructure($categoryTree->getConnection()),
    "category_tree" => $categoryTree->getTree()
];
// Вимірюємо час закінчення виконання скрипта
$endTime = microtime(true);
$executionTime = $endTime - $startTime;
echo "Час виконання: " . number_format($executionTime, 4) . " сек";


if ($executionTime > 2) {
    echo "<br><strong>Час виконання перевищує ліміт у 2 секунди.</strong>";
}

echo json_encode($response, JSON_PRETTY_PRINT);

?>