<?php
require_once 'Category.php';

// Початок таймера
$start_time = microtime(true);

$category = new Category();
$tree = $category->getCategoryTree();

// Кінець таймера
$execution_time = microtime(true) - $start_time;

// Вимкнення кешування
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0");

// Додаємо час виконання в HTML-коментар
echo "<!-- Час виконання скрипта: " . round($execution_time, 4) . " сек. -->";

// Вивід JSON
header('Content-Type: application/json');
echo json_encode($tree, JSON_PRETTY_PRINT);
?>
