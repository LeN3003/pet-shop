<?php
include 'includes/db.php';
include 'includes/header.php';

$cart_quantities = [];

//load cart of logged in customers
if (isset($_SESSION['customer_id'])) {
    $user_id = $_SESSION['customer_id'];
    $stmt = $conn->prepare("SELECT product_id, quantity FROM user_carts WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result_cart = $stmt->get_result();
    while ($row = $result_cart->fetch_assoc()) {
        $cart_quantities[$row['product_id']] = $row['quantity'];
    }
    $stmt->close();
}
//store cart of guest users
elseif (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $cart_quantities[$product_id] = $item['quantity'];
    }
}


?>

<div class="product-container">
    <?php
    $sql = "SELECT * FROM products WHERE available = 1";
    $result = $conn->query($sql);

    $dogs_food = $dogs_accessories = $cats_food = $cats_accessories = [];

    while ($row = $result->fetch_assoc()) {
        if ($row['type'] === 'dog' && $row['category'] === 'food') {
            $dogs_food[] = $row;
        } elseif ($row['type'] === 'dog' && $row['category'] === 'accessory') {
            $dogs_accessories[] = $row;
        } elseif ($row['type'] === 'cat' && $row['category'] === 'food') {
            $cats_food[] = $row;
        } elseif ($row['type'] === 'cat' && $row['category'] === 'accessory') {
            $cats_accessories[] = $row;
        }
    }

    function renderProductSection($title, $products)
    {
        echo "<h2>$title</h2>";
        echo '<div class="product-grid">';
        foreach ($products as $product) {
            $product_id = $product['id'];
            $is_in_cart = isset($GLOBALS['cart_quantities'][$product_id]);
            $quantity = $is_in_cart ? $GLOBALS['cart_quantities'][$product_id] : 1;

            echo '<div class="product-card">';
            echo '<img src="assets/images/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
            echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
            echo '<p>₹' . htmlspecialchars($product['price']) . '</p>';

            echo '<form method="POST" class="add-to-cart-form" action="handlers/add-to-cart.php">';
            echo '<input type="hidden" name="product_id" value="' . $product_id . '">';

            echo '<button class="add-btn" type="submit" ' . ($is_in_cart ? 'style="display:none;"' : '') . '>Add to Cart</button>';

            echo '<div class="quantity-control" style="' . ($is_in_cart ? '' : 'display:none;') . '">';
            echo '<button type="button" class="qty-btn minus">-</button>';
            echo '<input type="number" name="quantity" value="' . $quantity . '" min="1" class="qty-input">';
            echo '<button type="button" class="qty-btn plus">+</button>';
            echo '</div>';

            echo '<button class="remove-btn" type="button" style="' . ($is_in_cart ? '' : 'display:none;') . 'margin-top: 6px;">Remove</button>';

            echo '</form>';
            echo '</div>';
        }
        echo '</div>';
    }

    renderProductSection("Dog Food", $dogs_food);
    renderProductSection("Dog Accessories", $dogs_accessories);
    renderProductSection("Cat Food", $cats_food);
    renderProductSection("Cat Accessories", $cats_accessories);
    ?>
</div>

<script>
    const serverCartQuantities = <?= json_encode($cart_quantities) ?>;
</script>

<script src="assets/js/quantity.js" defer></script>

<?php include 'includes/footer.php'; ?>