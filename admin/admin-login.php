<?php
session_start();

$admin_user = 'admin';
$admin_pass = 'yourpassword';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin-dashboard.php');
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin-style.css" />
</head>

<body>
    <form method="POST">
        <h2>Admin Login</h2>
        <?php if ($error) echo "<p>$error</p>"; ?>
        <label>Username</label><br>
        <input type="text" name="username" required><br>
        <label>Password</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>