<?php
require_once 'db.php';
require_once 'Product.php';

header('Content-Type: application/json');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productInstance = new Product();
    $product = $productInstance->getProductById(intval($_GET['id']));

    if ($product) {
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Товар не знайдено']);
    }
} else {
    echo json_encode(['error' => 'Невірний запит']);
}
exit;

?>
