<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<div id="page-wrapper">

    <main class="container">
        <h2>My Orders</h2>

        <?php if ($orders->num_rows > 0): ?>
            <?php while ($order = $orders->fetch_assoc()): ?>

                <div class="order-summary">
                    <h3>Order #<?= $order['id'] ?> - ₹<?= $order['total'] ?></h3>
                    <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
                    <!-- <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></p> -->

                    <table>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                        <?php
                        $order_id = $order['id'];
                        $item_stmt = $conn->prepare("SELECT product_name, quantity, price FROM order_items WHERE order_id = ?");
                        $item_stmt->bind_param("i", $order_id);
                        $item_stmt->execute();
                        $items = $item_stmt->get_result();
                        while ($item = $items->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>₹<?= $item['price'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <p>You have no orders yet.</p>
        <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
</div>