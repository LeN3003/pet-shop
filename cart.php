<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
};


if (isset($_POST['update_cart'])) {
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
    $message[] = 'cart quantity updated successfully!';
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="style4.css">
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


    <div class="cart-container">
        <div class="user-profile">

            <?php
            $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_user) > 0) {
                $fetch_user = mysqli_fetch_assoc($select_user);
            };
            ?>

            <p><span><?php echo $fetch_user['username']; ?></span>'s Cart</p>
            <!-- <p> email : <span><?php echo $fetch_user['email']; ?></span> </p> -->
            <div class="flex">
                <!-- <a href="login.php" class="btn">login</a>
                <a href="register.php" class="option-btn">register</a> -->
                <a href="cart.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn">Logout</a>
            </div>

        </div>
        <div class="shopping-cart">

            <!-- <h1 class="heading">Cart</h1> -->

            <table>
                <thead>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                    $grand_total = 0;
                    if (mysqli_num_rows($cart_query) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
                    ?>
                            <tr>
                                <td><img src="images/<?php echo $fetch_cart['image']; ?>" height="250" width="250" alt=""></td>
                                <td><?php echo $fetch_cart['name']; ?></td>
                                <td>₹<?php echo $fetch_cart['price']; ?>/-</td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                        <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                        <input type="submit" name="update_cart" value="Update" class="option-btn">
                                    </form>
                                </td>
                                <td>₹<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
                                <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">Remove</a></td>
                            </tr>
                    <?php
                            $grand_total += $sub_total;
                        }
                    } else {
                        echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                    }
                    ?>
                    <tr class="table-bottom">
                        <td colspan="4">Grand Total :</td>
                        <td>₹<?php echo $grand_total; ?>/-</td>
                        <td><a href="cart.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Delete All</a></td>
                    </tr>
                </tbody>
            </table>

            <div class="cart-btn">
                <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
            </div>

        </div>

    </div>

</body>

</html>