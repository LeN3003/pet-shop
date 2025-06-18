<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit();
}

include '../includes/db.php';

// Fetch orders (basic)
$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Orders</title>
    <link rel="stylesheet" href="admin-orders.css">

</head>

<body>
    <h1>All Orders</h1>
    <a href="admin-dashboard.php">Back to Dashboard</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Total</th>
            <!-- <th>Details</th> -->
        </tr>
        <?php while ($order = $orders->fetch_assoc()) {
            // Calculate total
            $order_id = $order['id'];
            $items_res = $conn->query("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id");
            $total = 0;
            while ($item = $items_res->fetch_assoc()) {
                $total += $item['quantity'] * $item['price']; // Assuming price stored in order_items
            }
        ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['user_id'] ?></td>
                <td><?= $order['created_at'] ?></td>
                <!-- <td><?= htmlspecialchars($order['status']) ?></td> -->
                <td>₹<?= number_format($total, 2) ?></td>
                <td>
                    <?php
                    // Prepare items list string for alert, escaping quotes properly
                    $items_res->data_seek(0); // reset pointer
                    $lines = [];
                    while ($item = $items_res->fetch_assoc()) {
                        $lines[] = htmlspecialchars($item['name']) . ' x ' . $item['quantity'];
                    }
                    $alert_text = implode("\\n", $lines);
                    $alert_text_js = addslashes($alert_text); // escape quotes for JS
                    ?>
                    <button onclick="alert('Items:\n<?= $alert_text_js ?>')">View Items</button>

                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>