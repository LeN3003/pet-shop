<?php
include 'includes/db.php';
include 'includes/header.php';
//new added

$cart_quantities = [];
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

//----


?>
<link rel="stylesheet" href="assets/css/pages/products.css">

<h1>All Pet Products</h1>

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
            echo '<div class="product-card">';
            echo '<img src="assets/images/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
            echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
            echo '<p>₹' . htmlspecialchars($product['price']) . '</p>';

            echo '<form method="POST" action="handlers/add-to-cart.php" class="add-to-cart-form">';
            echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';

            echo '<div class="quantity-control">';
            echo '<button type="button" class="qty-btn minus">−</button>';
            echo '<input type="number" name="quantity" value="1" min="1" class="qty-input">';
            echo '<button type="button" class="qty-btn plus">+</button>';
            echo '</div>';

            echo '<button type="submit">Add to Cart</button>';
            echo '</form>';


            echo '</div>';
        }
        echo '</div>';
    }

    // Render each section
    renderProductSection("🐶 Dog Food", $dogs_food);
    renderProductSection("🦴 Dog Accessories", $dogs_accessories);
    renderProductSection("🐱 Cat Food", $cats_food);
    renderProductSection("🎀 Cat Accessories", $cats_accessories);
    ?>
</div>

<script>
    const serverCartQuantities = <?= json_encode($cart_quantities) ?>;
</script>


<!-- <?php
        $page = basename($_SERVER['PHP_SELF'], ".php");
        if ($page === 'products') {
            // echo '<script src="assets/js/modules/quantity-controls.js"></script>';
        }
        ?> -->

<?php include 'includes/footer.php'; ?>