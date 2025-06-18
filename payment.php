<?php
session_start();
include 'includes/db.php';


// var_dump($_SERVER['REQUEST_METHOD']);
// var_dump($_SESSION['cart']);

//from checkout.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {

    // echo "Condition passed, processing order.";
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $total = isset($_POST['total']) ? floatval($_POST['total']) : 0;

    // var_dump($name, $email, $address, $total);

    if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || $total <= 0) {
        die("Invalid order details. Please go back and try again.");
    }

    $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, email, address, total) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("isssd", $_SESSION['customer_id'], $name, $email, $address, $total);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $order_id = $stmt->insert_id;

    foreach ($_SESSION['cart'] as $pid => $item) {
        $pname = $item['name'];
        $qty = $item['quantity'];
        $price = $item['price'];

        $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt2) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt2->bind_param("iisid", $order_id, $pid, $pname, $qty, $price);

        if (!$stmt2->execute()) {
            die("Execute failed: " . $stmt2->error);
        }
        $stmt2->close();
    }

    unset($_SESSION['cart']);
    if (isset($_SESSION['customer_id'])) {
        $clear_stmt = $conn->prepare("DELETE FROM user_carts WHERE user_id = ?");
        $clear_stmt->bind_param("i", $_SESSION['customer_id']);
        $clear_stmt->execute();
    }
} else {
    die("No order found or cart empty.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payment Complete</title>
</head>

<body>
    <h1>Order Placed Successfully!</h1>
    <p>Thank you, <?= htmlspecialchars($name) ?>. Your order has been saved in our system.</p>
    <script>
        for (let key in localStorage) {
            if (key.startsWith("qty_")) {
                localStorage.removeItem(key);
            }
        }
    </script>

    <a href="index.php">Return to Shop</a>
</body>

</html>