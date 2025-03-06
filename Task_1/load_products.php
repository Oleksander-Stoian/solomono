<?php
require_once 'db.php';
require_once 'Product.php';

header('Content-Type: application/json');

$category = isset($_GET['category']) ? $_GET['category'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';

$productInstance = new Product();
$products = $productInstance->getProducts($category, $sort);

echo json_encode($products);
exit;

?>
