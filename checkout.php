<?php
include 'config.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <!-- <link rel="stylesheet" href=""> -->
    <link rel="stylesheet" href="checkout.css">

</head>

<body>



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


    <form method="post" action="">
        <h1>Checkout</h1>
        <div class="txt_field">

            <label>Name</label>
            <input type="text" id="name" name="name" required>
        </div>
<br>
        <label for="payment">Select Payment Method:</label>
        <select name="cars" id="cars">
            <option value="debit_credit">Debit/Credit Card</option>
            <option value="upi">UPI payment method</option>
            <option value="cod">Cash on Delivery</option>

        </select>
        <br><br>
        <input type="submit" value="Submit">

    </form>







</body>

</html>