<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

// Delete logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Products</title>
</head>

<body>

    <h2>📋 Product Management</h2>
    <p><a href="add-product.php">➕ Add New Product</a></p>
    <p><a href="orders.php">← Back to Orders</a></p>

    <table border="1" cellpadding="10">
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Type</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php
        $res = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
        while ($p = $res->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= $p['category'] ?></td>
                <td><?= $p['type'] ?></td>
                <td>₹<?= $p['price'] ?></td>
                <td><img src="../assets/images/<?= $p['image'] ?>" width="80"></td>
                <td>
                    <a href="edit-product.php?id=<?= $p['id'] ?>">✏️ Edit</a> |
                    <a href="products.php?delete=<?= $p['id'] ?>" onclick="return confirm('Delete this product?')">🗑️ Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>

</html>