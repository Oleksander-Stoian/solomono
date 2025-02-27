<?php
require_once 'Product.php';


$product = new Product();
$category = isset($_GET['category']) ? ($_GET['category'] !== 'all' ? intval($_GET['category']) : null) : null;
$sort = $_GET['sort'] ?? 'date_desc';

$products = $product->getProducts($category, $sort);

$output = "<ul id='product-list'>";
foreach ($products as $p) {
    $output .= "<li>
                    {$p['name']} - {$p['price']} грн
                    <button class='buy' data-id='{$p['id']}'>Купити</button>
                </li>";
}
$output .= "</ul>";

echo $output;
?>
