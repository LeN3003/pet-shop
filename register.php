<?php
include 'includes/header.php';
include 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start(); // just in case
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM customers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();

        $user_id = $stmt->insert_id;
        $_SESSION['customer_id'] = $user_id;
        $_SESSION['customer_name'] = $name;
        $_SESSION['customer_email'] = $email;

        // ✅ Migrate session cart to user_carts
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $item) {
                $quantity = $item['quantity'];

                // Insert directly (no need to check existing during registration)
                $insert_stmt = $conn->prepare("INSERT INTO user_carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
                $insert_stmt->execute();
                $insert_stmt->close();
            }
            // Optional: Clear session cart (comment if you want to keep it)
            // unset($_SESSION['cart']);
        }

        header("Location: index.php");
        exit();
    }

    $check->close();
}
?>



<div class="auth-container">
    <h2>📝 Register</h2>

    <?php if (!empty($error)): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="auth-form">
        <label for="name">Full Name</label>
        <input type="text" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php include 'includes/footer.php'; ?>