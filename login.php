<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'includes/header.php';
include 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Store guest cart before session gets overwritten
  $guest_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

  $email    = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, name, password FROM customers WHERE email = ?");

  if (!$stmt) {
    $error = "Something went wrong while syncing your cart. Please try again.";
  }

  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($id, $name, $hashed);

  if ($stmt->fetch() && password_verify($password, $hashed)) {

    $stmt->close();

    $_SESSION['customer_id'] = $id;
    $_SESSION['customer_name'] = $name;
    $_SESSION['customer_email'] = $email;

    //load cart of customer
    $cart_stmt = $conn->prepare("
        SELECT uc.product_id, uc.quantity, p.name, p.price, p.image
        FROM user_carts uc
        JOIN products p ON uc.product_id = p.id
        WHERE uc.user_id = ?
    ");

    if (!$cart_stmt) {
      die("Prepare failed (load DB cart): " . $conn->error);
    }

    $cart_stmt->bind_param("i", $id);
    $cart_stmt->execute();
    $result = $cart_stmt->get_result();

    $db_cart = [];
    //each row is associative array , db_cart ends up as associative array as well2
    while ($row = $result->fetch_assoc()) {
      $pid = $row['product_id'];
      $db_cart[$pid] = [
        'name'     => $row['name'],
        'price'    => $row['price'],
        'image'    => $row['image'],
        'quantity' => $row['quantity']
      ];
    }
    $cart_stmt->close();

    // merge guest cart into DB cart (prefer guest)
    $merged_cart = $db_cart;
    if (!empty($guest_cart)) {
      foreach ($guest_cart as $pid => $item) {
        $merged_cart[$pid] = $item;
      }
    }
    unset($_SESSION['cart']);

    // Save merged cart to session
    $_SESSION['cart'] = $merged_cart;

    // Delete existing user cart in DB
    $delete_stmt = $conn->prepare("DELETE FROM user_carts WHERE user_id = ?");
    if (!$delete_stmt) {
      die("Prepare failed (delete cart): " . $conn->error);
    }
    $delete_stmt->bind_param("i", $id);
    if (!$delete_stmt->execute()) {
      die("Execute failed (delete cart): " . $delete_stmt->error);
    }
    $delete_stmt->close();

    // Insert merged cart into DB
    if (!empty($merged_cart)) {
      $insert_stmt = $conn->prepare("INSERT INTO user_carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
      if (!$insert_stmt) {
        die("Prepare failed (insert cart): " . $conn->error);
      }
      foreach ($merged_cart as $pid => $item) {
        $insert_stmt->bind_param("iii", $id, $pid, $item['quantity']);
        if (!$insert_stmt->execute()) {
          die("Execute failed (insert cart) for PID $pid: " . $insert_stmt->error);
        }
      }
      $insert_stmt->close();
    }

    header("Location: index.php");
    exit();
  } else {
    $error = "Invalid email or password.";
    $stmt->close();
  }
}
?>


<div class="auth-container">
  <h2>Login</h2>
  <?php if (!empty($error)): ?>
    <div class="error-msg"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" class="auth-form">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
  </form>
  <p>New customer? <a href="register.php">Register here</a></p>
</div>


<?php include 'includes/footer.php'; ?>