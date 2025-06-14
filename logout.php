<!-- <?php
        session_start();
        session_unset();
        session_destroy();
        // Set flag to indicate we just logged out
        session_start(); // restart session to set flag
        $_SESSION['just_logged_out'] = true;

        header("Location: index.php");
        exit();
        ?> -->

<?php
session_start();

// Preserve guest cart
$guest_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Remove only user info
unset($_SESSION['customer_id']);
unset($_SESSION['customer_name']);
unset($_SESSION['customer_email']);

// Restore guest cart
$_SESSION['cart'] = $guest_cart;

// Optional: for a logout success message
$_SESSION['just_logged_out'] = true;

header("Location: index.php");
exit;
?>