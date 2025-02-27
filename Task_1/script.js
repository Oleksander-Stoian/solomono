$(document).ready(function() {
    function loadProducts(category = null, sort = 'date_desc') {
        let params = new URLSearchParams(window.location.search);

        // Якщо категорія вже є в URL, використовуємо її
        if (category === null && params.has('category')) {
            let urlCategory = params.get('category');
            category = urlCategory !== 'all' ? urlCategory : null;
        }

        params.set('sort', sort);
        if (category !== null) {
            params.set('category', category);
        } else {
            params.delete('category');
        }

        console.log("Передача даних:", category, sort); // Додаємо лог для перевірки
        history.pushState(null, '', '?' + params.toString());

        $.ajax({
            url: "load_products.php",
            type: "GET",
            data: { category: category !== 'all' ? category : null, sort: sort },
            success: function(data) {
                $("#product-list").html(data);
            }
        });
    }

    let urlParams = new URLSearchParams(window.location.search);
    let category = urlParams.get('category') || 'all';
    let sort = urlParams.get('sort') || 'date_desc';

    $(".category").click(function() {
        let categoryId = $(this).data("id");
        $(".category").removeClass("active"); // Видаляємо активний клас
        $(this).addClass("active"); // Додаємо активний клас
        category = categoryId; // Оновлюємо категорію
        loadProducts(category, sort);
    });

    $("#sort").change(function() {
        let sortValue = $(this).val();
        let activeCategory = $(".category.active").data("id"); // Отримуємо активну категорію
        if (!activeCategory || activeCategory === 'all') {
            activeCategory = null; // Якщо вибрано "Всі", не передаємо категорію
        }
        loadProducts(activeCategory, sortValue);
    });

    loadProducts(category, sort);
});

$(document).on("click", ".buy", function() {
    let productId = $(this).data("id");
    
    console.log("Клік по кнопці 'Купити', ID товару:", productId); // Відстежуємо клік

    $.ajax({
        url: "get_product.php",
        type: "GET",
        data: { id: productId },
        success: function(data) {
            console.log("Отримані дані від сервера:", data); // Відстежуємо отримані дані

            let product = JSON.parse(data);
            $("#modal-product-name").text(product.name);
            $("#modal-product-price").text(product.price);
            $("#buyModal").show();
        },
        error: function(xhr, status, error) {
            console.error("Помилка AJAX:", error);
        }
    });
});
