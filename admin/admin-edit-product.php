<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit();
}

include '../includes/db.php';

$error = '';
$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: admin-dashboard.php');
    exit();
}

// Fetch product data
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    header('Location: admin-dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $image = trim($_POST['image']);
    $available = intval($_POST['available']);

    if ($name === '' || $type === '' || $category === '' || $description === '' || $price <= 0 || $image === '') {
        $error = "Please fill all fields correctly.";
    } else {
        $update = $conn->prepare("UPDATE products SET name=?, type=?, category=?, description=?, price=?, image=?, available=? WHERE id=?");

        if (!$update) {
            echo "<script>console.log('Product not sucesss');</script>";
            $error = "Prepare failed: " . $conn->error;
        } else {
            $update->bind_param("ssssdsii", $name, $type, $category, $description, $price, $image, $available, $id);
            if ($update->execute()) {
                header('Location: admin-dashboard.php');
                exit();
            } else {
                $error = "Error updating product: " . $update->error;
            }




            $update->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product #<?= htmlspecialchars($id) ?></title>
</head>

<body>
    <h2>Edit Product #<?= htmlspecialchars($id) ?></h2>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Name:</label><br>
        <input name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

        <label>Type (dog/cat):</label><br>
        <input name="type" value="<?= htmlspecialchars($product['type']) ?>" required><br><br>

        <label>Category (food/accessory):</label><br>
        <input name="category" value="<?= htmlspecialchars($product['category']) ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea><br><br>

        <label>Price:</label><br>
        <input name="price" type="number" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required><br><br>

        <label>Image filename:</label><br>
        <input name="image" value="<?= htmlspecialchars($product['image']) ?>" required><br><br>

        <label>Available :</label><br>
        <input name="available" type="number" min="0" value="<?= htmlspecialchars($product['available']) ?>" required><br><br>

        <button type="submit">Update Product</button>
    </form>
    <a href="admin-dashboard.php">Back to Dashboard</a>
</body>

</html>