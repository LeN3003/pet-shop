
<?php
session_start();

// Preserve only cart
$customer_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Remove only user info
unset($_SESSION['customer_id']);
unset($_SESSION['customer_name']);
unset($_SESSION['customer_email']);

// Restore the cart
$_SESSION['cart'] = $customer_cart;

$_SESSION['just_logged_out'] = true;

header("Location: index.php");
exit;
?>