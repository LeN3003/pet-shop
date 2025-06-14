<?php
session_start();

// Hardcoded admin credentials
$ADMIN_EMAIL = "admin@petshop.com";
$ADMIN_PASS = "admin123"; // In real apps, hash this

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if ($email === $ADMIN_EMAIL && $pass === $ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: orders.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
</head>

<body>
    <h2>🔐 Admin Login</h2>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>