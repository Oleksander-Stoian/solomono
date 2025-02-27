<?php
require_once 'Category.php';


$start_time = microtime(true);

$category = new Category();
$tree = $category->getCategoryTree();


$execution_time = microtime(true) - $start_time;


header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0");


echo "<!-- Час виконання скрипта: " . round($execution_time, 4) . " сек. -->";


header('Content-Type: application/json');
echo json_encode($tree, JSON_PRETTY_PRINT);
?>
