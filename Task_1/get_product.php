<?php
require_once 'Product.php';

$product = new Product();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$item = $product->getProductById($id);

if ($item) {
    echo json_encode($item);
} else {
    echo json_encode(["error" => "Товар не знайдено"]);
}
?>
