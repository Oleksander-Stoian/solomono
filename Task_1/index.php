<?php
require_once 'Category.php';

$category = new Category();
$categories = $category->getAllCategories();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товари</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
<body>

<div class="header">Товари</div>

<div class="container">
    <div id="categories">
        <h3>Категорії</h3>
        <ul>
            <li><a href="#" class="category" data-id="all">Всі (<?= array_sum(array_column($categories, 'product_count')) ?>)</a></li>
            <?php foreach ($categories as $category): ?>
                <li>
                    <a href="#" class="category" data-id="<?= $category['id'] ?>">
                        <?= $category['name'] ?> (<?= $category['product_count'] ?>)
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div id="products">
        <h3>Товари</h3>
        <select id="sort">
		    <option value="date_desc">Новіші</option>
            <option value="price_asc">Дешевші</option>
            <option value="name_asc">По алфавіту</option>
        </select>
        <div id="product-list"></div>
    </div>
</div>

<!-- Модальне вікно -->
<div id="buyModal">
    <h3>Товар: <span id="modal-product-name"></span></h3>
    <p>Ціна: <span id="modal-product-price"></span> грн</p>
    <button onclick="$('#buyModal').hide();">Закрити</button>
</div>

</body>
</html>
