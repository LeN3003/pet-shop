<?php
include '../includes/db.php';
?>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<p><a href="logout.php">🚪 Logout</a></p>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>All Orders - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>

    <h1>📦 All Customer Orders</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Total (₹)</th>
            <th>Date</th>
            <th>Details</th>
        </tr>

        <?php
        $orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");

        while ($row = $orders->fetch_assoc()) {
            echo "<tr>
            <td>{$row['id']}</td>
            <td>" . htmlspecialchars($row['customer_name']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>{$row['total']}</td>
            <td>{$row['created_at']}</td>
            <td><a href='order-details.php?id={$row['id']}'>View</a></td>
        </tr>";
        }
        ?>
    </table>

</body>

</html>