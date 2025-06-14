<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit();
}

$id = $_GET['id'];

// Fetch existing product data
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'];
    $category = $_POST['category'];
    $type     = $_POST['type'];
    $price    = $_POST['price'];

    // Check if image is uploaded
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "../assets/images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $product['image']; // keep existing
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, category=?, type=?, price=?, image=? WHERE id=?");
    $stmt->bind_param("sssdsi", $name, $category, $type, $price, $image, $id);
    $stmt->execute();

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
</head>

<body>

    <h2>✏️ Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

        <label>Category:</label><br>
        <select name="category">
            <option value="Dog" <?= $product['category'] === 'Dog' ? 'selected' : '' ?>>Dog</option>
            <option value="Cat" <?= $product['category'] === 'Cat' ? 'selected' : '' ?>>Cat</option>
        </select><br><br>

        <label>Type:</label><br>
        <select name="type">
            <option value="Food" <?= $product['type'] === 'Food' ? 'selected' : '' ?>>Food</option>
            <option value="Accessory" <?= $product['type'] === 'Accessory' ? 'selected' : '' ?>>Accessory</option>
        </select><br><br>

        <label>Price (₹):</label><br>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br><br>

        <label>Image:</label><br>
        <input type="file" name="image"><br>
        <small>Current: <?= $product['image'] ?></small><br><br>

        <button type="submit">Update Product</button>
    </form>

    <p><a href="products.php">← Back to Products</a></p>

</body>

</html>