<?php
include '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "Order ID missing!";
    exit;
}

$order_id = $_GET['id'];

// Fetch order info
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Fetch items
$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order #<?= $order_id ?> Details</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>

    <h1>🧾 Order #<?= $order_id ?> Details</h1>

    <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
    <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
    <p><strong>Total:</strong> ₹<?= $order['total'] ?></p>
    <p><strong>Date:</strong> <?= $order['created_at'] ?></p>

    <h2>🛍️ Items:</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price (₹)</th>
            <th>Subtotal</th>
        </tr>
        <?php
        while ($item = $items->fetch_assoc()):
            $subtotal = $item['quantity'] * $item['price'];
        ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item['price'] ?></td>
                <td><?= $subtotal ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <p><a href="orders.php">← Back to All Orders</a></p>

</body>

</html>