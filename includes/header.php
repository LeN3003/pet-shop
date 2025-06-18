<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pet Shop</title>

    <link rel="stylesheet" href="assets/css/main.css">

    <?php

    $page = basename($_SERVER['PHP_SELF'], ".php");
    $pagesWithStyles = ['checkout', 'cart', 'my-orders', 'products'];
    if (in_array($page, $pagesWithStyles)) {
        echo '<link rel="stylesheet" href="assets/css/pages/' . $page . '.css">';
    }


    ?>
</head>

<body>
    <header>
        <div class="container">
            <h1 class="logo">Pet Shop</h1>
            <nav class="navbar">
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="about.php">About Us</a>
                <a href="cart.php">Cart</a>

                <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="my-orders.php">My Orders</a>
                    <span class="user">Hi, <?= htmlspecialchars($_SESSION['customer_name']) ?></span>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main>