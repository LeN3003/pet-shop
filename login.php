<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, md5($_POST['password']));
  $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE  email = '$email' ") or die('query failed');

  if (mysqli_num_rows($select) > 0) {
    $row = mysqli_fetch_assoc($select);
    $_SESSION['user_id'] = $row['id'];
    header('location:dogs.php');
  } else {
    $message[] = 'incorrect password or email!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <!-- <link rel="stylesheet" href=""> -->
  <link rel="stylesheet" href="style5.css">
</head>

<body>

  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
    }
  }
  ?>

  <header class="header">
    <a href="#" class="logo"><i class="fa-solid fa-paw">Pet shop</i></a>
    <nav class="navbar">
      <a href="homepage.html">Home</a>
      <a href="cats.php">Cats</a>
      <a href="dogs.php">Dogs</a>
      <a href="register.php">Register</a>
      <a href="aboutus.html">About</a>
    </nav>
    <div class="icons">
      <a href="cart.php">
        <div class="fa fa-shopping-cart" id="cart-btn"></div>
      </a>
      <a href="login.php">
        <div class="fa fa-user" id="user-btn"></div>
      </a>
    </div>
  </header>

  <div class="center">
    <form method="post" action="">
      <h1>Login</h1>
      <div class="txt_field">
        <input type="email" id="email" name="email" required>
        <label>Email</label>
      </div>
      <div class="txt_field">
        <input type="password" id="password" name="password" required>
        <label>Password</label>
      </div>
      <input type="submit" value="Login" name="submit">
      <div class="signup_link">
        Not a member?<a href="register.php">Register Now</a>
      </div>
    </form>
  </div>

</body>

</html>