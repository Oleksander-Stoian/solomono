$(document).ready(function() {
    function loadProducts(category = null, sort = 'date_desc') {
        let params = new URLSearchParams(window.location.search);

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

        console.log("Передача даних:", category, sort);
        history.pushState(null, '', '?' + params.toString());

        $.ajax({
            url: "load_products.php",
            type: "GET",
            data: { category: category !== 'all' ? category : null, sort: sort },
            dataType: "json",
            success: function(data) {
                $("#product-list").html("");

                if (data.length > 0) {
                    data.forEach(product => {
                        $("#product-list").append(`
                            <li>
                                <h3>${product.name}</h3>
                                <p>Ціна: ${product.price} грн</p>
                                <button class="buy" data-id="${product.id}">Купити</button>
                            </li>
                        `);
                    });
                } else {
                    $("#product-list").html("<p>Немає товарів у цій категорії.</p>");
                }
            },
            error: function(xhr, status, error) {
                console.error("Помилка AJAX:", xhr.responseText); // Додано для дебагу
            }
        });
    }

    let urlParams = new URLSearchParams(window.location.search);
    let category = urlParams.get('category') || 'all';
    let sort = urlParams.get('sort') || 'date_desc';

    $(".category").click(function() {
        let categoryId = $(this).data("id");
        $(".category").removeClass("active");
        $(this).addClass("active");
        category = categoryId;
        loadProducts(category, sort);
    });

    $("#sort").change(function() {
        let sortValue = $(this).val();
        let activeCategory = $(".category.active").data("id");
        if (!activeCategory || activeCategory === 'all') {
            activeCategory = null;
        }
        loadProducts(activeCategory, sortValue);
    });

    loadProducts(category, sort);
});

$(document).on("click", ".buy", function() {
    let productId = $(this).data("id");

    console.log("Клік по кнопці 'Купити', ID товару:", productId);

    $.ajax({
        url: "get_product.php",
        type: "GET",
        data: { id: productId },
        dataType: "json",
        success: function(product) {
            console.log("Отримані дані від сервера:", product);

            if (product.error) {
                alert(product.error);
            } else {
                $("#modal-product-name").text(product.name);
                $("#modal-product-price").text(product.price + " грн");
                $("#buyModal").show();
            }
        },
        error: function(xhr, status, error) {
            console.error("Помилка AJAX:", xhr.responseText);
        }
    });
});
