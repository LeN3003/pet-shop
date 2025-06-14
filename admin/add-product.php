<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $price = $_POST['price'];

    // Upload image
    $image = $_FILES['image']['name'];
    $target = "../assets/images/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $stmt = $conn->prepare("INSERT INTO products (name, category, type, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $name, $category, $type, $price, $image);
    $stmt->execute();

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
</head>

<body>
    <h2>➕ Add Product</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Category:</label><br>
        <select name="category">
            <option value="Dog">Dog</option>
            <option value="Cat">Cat</option>
        </select><br><br>

        <label>Type:</label><br>
        <select name="type">
            <option value="Food">Food</option>
            <option value="Accessory">Accessory</option>
        </select><br><br>

        <label>Price (₹):</label><br>
        <input type="number" name="price" step="0.01" required><br><br>

        <label>Image:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Add Product</button>
    </form>

</body>

</html>