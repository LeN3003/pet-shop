<?php
session_start();
include 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];

$total = 0;
?>

<h2>Your Shopping Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
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

<?php include 'includes/footer.php'; ?>