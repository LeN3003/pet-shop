<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

// Clear cart
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    if (isset($_SESSION['customer_id'])) {
        $user_id = $_SESSION['customer_id'];
        $stmt = $conn->prepare("DELETE FROM user_carts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: cart.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<div id="page-wrapper">

    <h2>Your Shopping Cart</h2>

    <?php if (empty($cart)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>

        <form method="POST">

            <button type="submit" name="clear_cart" class="clear-cart-btn">Clear Cart</button>

        </form>

        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($cart as $id => $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>₹<?= $item['price'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>₹<?= $subtotal ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>₹<?= $total ?></strong></td>
            </tr>
        </table>
        <a href="checkout.php"><button>Proceed to Checkout</button></a>
    <?php endif; ?>

</div>
<?php include 'includes/footer.php'; ?>