<?php
session_start();
include 'includes/header.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p class='empty-cart-msg'>Your cart is empty.</p>";
    include 'includes/footer.php';
    exit();
}

$total = array_sum(array_map(function ($item) {
    return $item['price'] * $item['quantity'];
}, $cart));
?>

<div class="checkout-container">
    <h2>Checkout Summary</h2>

    <div class="checkout-summary">
        <ul>
            <?php foreach ($cart as $item): ?>
                <li>
                    <?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?>
                    <span>₹<?= $item['price'] * $item['quantity'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total: ₹<?= $total ?></strong></p>
    </div>

    <form action="payment.php" method="POST">
        <input type="hidden" name="name" value="<?= htmlspecialchars($_SESSION['customer_name']) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($_SESSION['customer_email'] ?? '') ?>">

        <input type="hidden" name="address" value="Default Address">
        <input type="hidden" name="total" value="<?= $total ?>">
        <button type="submit">Pay Now</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>