<?php
session_start();

if (isset($_POST['update']) && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($qty));
        }
    }
}

if (isset($_POST['remove'])) {
    $remove_id = $_POST['remove'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
}

header("Location: ../cart.php");
exit();
