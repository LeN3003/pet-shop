<?php
include 'config.php';
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email' AND password='$password'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'user already exist!';
    } else {
        mysqli_query($conn, "INSERT INTO `user_form` (username ,email,address,contact,pincode,password) VALUES('$username','$email','$address','$contact','$pincode','$password')") or die('query failed');
        $message[] = 'Registered successfully!';
        header('location:login.php');
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="style2.css">
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

    <div class="container">

        <form action="" method="post">
            <h2>Registration</h2>
            <div class="content">
                <div class="input-box">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" />
                </div>
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Emailid" />
                </div>
                <div class="input-box">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter address" />
                </div>
                <div class="input-box">
                    <label for="contact">Contact number</label>
                    <input type="tel" id="contact" name="contact" placeholder="Enter Contact number" />
                </div>
                <div class="input-box">
                    <label for="pincode">Pincode</label>
                    <input type="text" id="pincode" name="pincode" placeholder="Enter Pincode" />
                </div>
                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter password" />
                </div>
                <div class="input-box">
                    <label for="confirm_password"> Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Enter confirmed password" />
                </div>

            </div>
            <div class="alert">
                <p>By clicking signup u agree to our <a href="#">Terms, </a><a href="#">Privacy policy </a> and <a href="#"> cookies policy.</a></p>
                <p>Already have an account?<a href="login.php">login now</a></p>
            </div>
            <div class="button-container">
                <button type="submit" name="submit">Register</button>
            </div>

        </form>
    </div>
</body>

</html>