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

if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($select_cart) > 0) {
        $message[] = 'Product already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
        $message[] = 'Product added to cart!';
    }
};



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="dogs_style.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <title>Cats</title>

</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo  '<div class="message" onclick="this.remove();">' . $message . '</div>';
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

        <div class="user-profile">

            <?php
            $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_user) > 0) {
                $fetch_user = mysqli_fetch_assoc($select_user);
            };
            ?>

            <p> Welcome <span><?php echo $fetch_user['username']; ?></span> explore our Cat products</p>
            <!-- <p> email : <span><?php echo $fetch_user['email']; ?></span></p> -->
            <div class="flex">

                <a href="dogs2.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn">logout</a>
            </div>

        </div>



        <button class="dry_dog_food">Cat Food</button>
        <div id="div1" class="products-container">

            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='british-shorthair-adult.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-1">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>

            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='whiskas_cat.jpg' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-2">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>


            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='sheba_cat.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-3">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>
        </div>
        <br>



        <!-- wet dog food -->

        <button class="wet_dog_food">Cat Litter & Accessories </button>
        <div id="div2" class="products-container">

            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='M-pets_bamboo_cat_litter.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-5">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>


            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='Emily Pets Premium Bentonite Cat Litter.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-6">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>

            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='NatureMiracle.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-7">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>

        </div>
        <br>



        <!-- toys -->
        <button class="dog_toys">Cat Furniture & Scratchers </button>
        <div id="div3" class="products-container">




            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='cat_elite.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-8">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>



            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='cat_furniture_m-pets.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-9">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>




            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='trixie.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-10">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                        <input type="number" min="1" name="product_quantity" value="1" class="pr_quantity">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                };
            };
            ?>

        </div>
        <br>



    </div>





    <div class="products-preview">

        <div class="preview" data-target="p-1">
            <i class="fas fa-times"></i>
            <img src="images\british-shorthair-adult.webp" alt="">
            <h3>Royal Canin British Shorthair Adult Dry Cat Food (2kg) </h3>
            <div class="price">₹1944</div>
            <p>Royal Canin British Shorthair Adult in Gravy is specially formulated with all the nutritional needs of your British Shorthair cat in mind. The British Shorthair typically has a sturdy, heavy and muscular body. As a naturally solid and powerful cat, your cat's weight should primarily derive from muscle instead of fat. Therefore, the right nutrients (as well as correct portion sizes) are essential. </p>

        </div>

        <div class="preview" data-target="p-2">
            <i class="fas fa-times"></i>
            <img src="images/whiskas_cat.jpg" alt="">
            <h3>Whiskas Adult (+1 year) Wet Cat Food, Chicken in Gravy, 12 Pouches (12 x 85g)</h3>
            <div class="price">₹774</div>
            <p>Formulated with omega 3 & 6 fats and zinc for a healthy and shiny coat.
                Complete with vitamin A and taurine for healthy eyesight.
                Filled with proteins from real chicken, including fats, vitamins, and minerals, so your cat stays fit and happy.</p>
        </div>

        <div class="preview" data-target="p-3">
            <i class="fas fa-times"></i>
            <img src="images/sheba_cat.webp" alt="">
            <h3>Sheba Premium Wet Cat Food - Chicken Loaf for Kittens (70g x 12 Pouches) </h3>
            <div class="price">₹672</div>
            <p>
                Premium cat food for your kitten
                Designed as a complement to your kitten’s complete and balanced diet
                High-quality meal that offers a tantalizing texture
                Comes in an easier to chew loaf format
                Sheba cat food is mouth-watering and ideal for little cats
            </p>
        </div>

        <div class="preview" data-target="p-5">
            <i class="fas fa-times"></i>
            <img src="images/M-pets_bamboo_cat_litter.webp" alt="">
            <h3>M-Pets Bamboo Organic Cat Litter - 2.1Kg</h3>
            <div class="price">₹675</div>
            <p>Ingredients: Chicken, Chicken by-products,Gravy, Wheat gluten, Colouring agents, Flavor, No beef or pork.
            </p>

        </div>

        <div class="preview" data-target="p-6">
            <i class="fas fa-times"></i>
            <img src="images/Emily Pets Premium Bentonite Cat Litter.webp" alt="">
            <h3>Emily Pets Premium Bentonite Cat Litter - Fresh Scented Lavender </h3>
            <div class="price">₹1079</div>
            <p>100% natural bentonite: This cat litter is made up of Natural Wyoming Bentonite - 100% safe your kittens and cats.

                Odour Control: enhanced with highly activated carbon to reduce odors in the cat litter box and home environments. The raw material of activated carbon is pure natural sustainable organic. </p>

        </div>


        <div class="preview" data-target="p-7">
            <i class="fas fa-times"></i>
            <img src="images/NatureMiracle.webp" alt="">
            <h3>Nature's Miracle - Cat Melon Burst Stain & Odour Remover (32oz / 946ml) </h3>
            <div class="price">₹1035</div>
            <p>
                Works to remove pet stains and odors
                Freshens with a melon burst scent
                Bacteria-based formula produces enzymes when it comes in contact with Bio material to help remove organic stains and odors
            </p>

        </div>

        <div class="preview" data-target="p-8">
            <i class="fas fa-times"></i>
            <img src="images/cat_elite.webp" alt="">
            <h3>CatElite Cat Tree - Snake Janga</h3>
            <div class="price">₹2475</div>
            <p>Adding cat furniture, i.e. cat scratch board and/or cat scratch pole, reduces boredom-based furniture destruction and re-directs your cat's energy onto scratching something productive. </p>
        </div>

        <div class="preview" data-target="p-9">
            <i class="fas fa-times"></i>
            <img src="images/cat_furniture_m-pets.webp" alt="">
            <h3>M-Pets Cat Furniture - Milson Box </h3>
            <div class="price">₹2789</div>
            <p>
                Felt surface
                Two entrance
                Hide and seek, play with Fun
                One Size :
                L x W x H = 39.5 x 39.5 x 39.5 cm

            </p>

        </div>

        <div class="preview" data-target="p-10">
            <i class="fas fa-times"></i>
            <img src="images/trixie.webp" alt="">
            <h3>Trixie Mimi Cat Scratching Wave - Wine Red </h3>
            <div class="price">₹2375</div>
            <p>
                Soft, comfortable flannel floor
                Tunnel made of durable, corrugate material
                Great for one or multiple cats
                Easy to assemble and fold away
            </p>

        </div>

    </div>

    <script src="dogs_script.js" defer></script>
    </div>
</body>

</html>