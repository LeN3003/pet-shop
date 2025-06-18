<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit();
}
include '../includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $image = trim($_POST['image']);
    $available = isset($_POST['available']) ? intval($_POST['available']) : 1;

    if ($name === '' || $type === '' || $category === '' || $description === '' || $price <= 0 || $image === '') {
        $error = "Please fill all fields correctly.";
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, type, category, description, price, image, available) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            $error = "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("ssssssi", $name, $type, $category, $description, $price, $image, $available);
            if ($stmt->execute()) {
                header('Location: admin-dashboard.php');
                exit();
            } else {
                $error = "Error adding product: " . $stmt->error;
            }
        }
    }
}
?>

<h2>Add New Product</h2>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <label>Name:</label><br>
    <input name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required><br>

    <label>Type (dog/cat):</label><br>
    <input name="type" value="<?= htmlspecialchars($_POST['type'] ?? '') ?>" required><br>

    <label>Category (food/accessory):</label><br>
    <input name="category" value="<?= htmlspecialchars($_POST['category'] ?? '') ?>" required><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea><br>

    <label>Price:</label><br>
    <input name="price" type="number" step="0.01" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required><br>

    <label>Image filename:</label><br>
    <input name="image" value="<?= htmlspecialchars($_POST['image'] ?? '') ?>" required><br>

    <label>Available Quantity:</label><br>
    <input name="available" type="number" min="0" value="<?= htmlspecialchars($_POST['available'] ?? 1) ?>" required><br><br>

    <button type="submit">Add Product</button>
</form>

<a href="admin-dashboard.php">Back to Dashboard</a>