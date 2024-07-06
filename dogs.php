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

    <title>Dogs</title>

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

            <p> Welcome <span><?php echo $fetch_user['username']; ?></span> explore our Dog products</p>
            <!-- <p> email : <span><?php echo $fetch_user['email']; ?></span></p> -->
            <div class="flex">

                <a href="dogs2.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn">logout</a>
            </div>

        </div>



        <button class="dry_dog_food">Dry Dog Food</button>
        <div id="div1" class="products-container">

            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='drools_puppy_food.jpg' ") or die('query failed');
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='himalayan_puppy_food.jpg' ") or die('query failed');
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='royal_canin_german_puppy_food.jpg' ") or die('query failed');
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

        <button class="wet_dog_food">Wet Dog Food</button>
        <div id="div2" class="products-container">

            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='pedigree_wet_dog_food.jpg' ") or die('query failed');
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='drools-puppy-wet-dog-food-real-chicken-chicken-liver-chunks-in-gravy.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-6">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">v<?php echo $fetch_product['price']; ?>/-</div>
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='Kennel Kitchen Wet Dog Food.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-7">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">v<?php echo $fetch_product['price']; ?>/-</div>
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
        <button class="dog_toys">Dog Toys</button>
        <div id="div3" class="products-container">




            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='chuckit_fetch_toy.jpg' ") or die('query failed');
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='kong_goodie_bone.jpg' ") or die('query failed');
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='petsport.webp' ") or die('query failed');
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
        <!-- dog accessories -->
        <button class="dog_accessories">Dog Accessories</button>
        <div id="div4" class="products-container">



            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='M-Pets_Dog_Collars.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-11">
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='ruffwear.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-12">
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='leashes.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-13">
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
        <!-- carriers & travel -->
        <button class="carriers_travel">Carriers & Travel</button>
        <div id="div5" class="products-container">




            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='Savic_Trotter.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-14">
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='backpack.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-15">
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
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE image='m-pet_stroller.webp' ") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="images/<?php echo $fetch_product['image']; ?>" alt="" class="product" data-name="p-16">
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





        <div class="products-preview">

            <div class="preview" data-target="p-1">
                <i class="fas fa-times"></i>
                <img src="images/drools_puppy_food.jpg" alt="">
                <h3>Drools Dry Dog Food for Puppies - Chicken and Egg</h3>
                <div class="price">₹679</div>
                <p>Ingredients :
                    Chicken, Whole Dried Eggs, Corn, Rice, Wheat, Corn Gluten Meal, Fish Oil, Soya Refined Oil, Corn Oil, Lecithin, Essential Amino Acids, Minerals, Vitamins, Salt And Antioxidants. </p>

            </div>

            <div class="preview" data-target="p-2">
                <i class="fas fa-times"></i>
                <img src="images/himalayan_puppy_food.jpg" alt="">
                <h3>Himalaya Healthy Pet Food - Puppy - Chicken & Rice</h3>
                <div class="price">₹774</div>
                <p>Ingredients:
                    Cereal and Cereal Products, Chicken and Chicken Products, Rice, Poultry Fat, Meat and Meat Products, Vegetable Oil, Taste Enhancer, Calcium Phosphate, Maize Gluten Meal, Carrot Powder, Oats (Avena Sativa), Sodium Chloride, Choline Chloride, Papaya (Carica Papaya), L-Threonine vitamins, Potassium Chloride, Permitted Antioxidants, Minerals, Zinc Sulphate, Black Pepper (Piper Nigrum) and Permitted Preservatives.</p>
            </div>

            <div class="preview" data-target="p-3">
                <i class="fas fa-times"></i>
                <img src="images/royal_canin_german_puppy_food.jpg" alt="">
                <h3>Royal Canin German Shepherd Puppy Dry Dog Food</h3>
                <div class="price">₹864</div>
                <p>Composition: dehydrated poultry protein, rice, vegetable protein isolate*, wheat flour, maize flour, animal fats, hydrolysed animal proteins, beet pulp, vegetable fibres, fish oil, minerals, soya oil, fructo-oligo-saccharides (0.34%).</p>
            </div>

            <div class="preview" data-target="p-5">
                <i class="fas fa-times"></i>
                <img src="images/pedigree_wet_dog_food.jpg" alt="">
                <h3>Pedigree Puppy Wet Dog Food, Chicken Chunks In Gravy, 70 G</h3>
                <div class="price">₹675</div>
                <p>Ingredients: Chicken, Chicken by-products,Gravy, Wheat gluten, Colouring agents, Flavor, No beef or pork.
                </p>

            </div>

            <div class="preview" data-target="p-6">
                <i class="fas fa-times"></i>
                <img src="images/drools-puppy-wet-dog-food-real-chicken-chicken-liver-chunks-in-gravy.webp" alt="">
                <h3>Drools Wet Food For Puppies - Real Chicken And Chicken Liver Chunks In Gravy</h3>
                <div class="price">₹425</div>
                <p>Ingredients
                    Real Chicken, Liver, Eggs, Gravy, Gelling Agents, Natural Flavors, Organic Minerals & Vitamins (Vit E, Vit A, Vit C, Vit D3, Vit B1, Vit B2, Vit B6, Choline, Folic Acid). </p>

            </div>


            <div class="preview" data-target="p-7">
                <i class="fas fa-times"></i>
                <img src="images/Kennel Kitchen Wet Dog Food.webp" alt="">
                <h3>Kennel Kitchen Wet Dog Food - Chicken Chunks In Gravy (Pack Of 12 X 70g Pouches)</h3>
                <div class="price">₹408</div>
                <p>Ingredients:
                    Made with premium quality lamb that provides essential amino acids for muscle development. Wheat Free - Highly digestible, provide optimum nutrition without using fillers. Contains natural vitamins and minerals that are required for a strong immune system.</p>
            </div>

            <div class="preview" data-target="p-8">
                <i class="fas fa-times"></i>
                <img src="images/chuckit_fetch_toy.jpg" alt="">
                <h3>Chuckit! Dog Toys - Kick Fetch Ball</h3>
                <div class="price">₹2750</div>
                <p> The Chuckit! Large Kit Fetch Ball features deep ridges which make it easier for your dog to retrieve. The durable canvas, rubber and EVA foam construction make it the perfect dog ball for outside games of fetch and interactive fun with your dog.
                    Unique grooved design allows your dog to easily pick up and bring it right back to you.
                    The vibrant, high-visibility orange color makes this toy easy to track in large open spaces or in water. </p>

            </div>

            <div class="preview" data-target="p-9">
                <i class="fas fa-times"></i>
                <img src="images/kong_goodie_bone.jpg" alt="">
                <h3>KONG Goodie Bone</h3>
                <div class="price">₹810</div>
                <p>Kong goodie bone dog toy small is a classic bone shape dog toy. This kong product made in usa and is extremely durable. This bone shaped toy keeps the dogs engaged when you are away from them. It has place to hold snacks for your dog. Its main use is that it is a toy for dog and dog love to play with it. The bone dog toy can also be useful when dogs are teething because their gums and jaws become very sore and chewing on things provides them relief.</p>
            </div>

            <div class="preview" data-target="p-10">
                <i class="fas fa-times"></i>
                <img src="images/petsport.webp" alt="">
                <h3>Petsport 4" Giant Tuff Ball (1pk)</h3>
                <div class="price">₹495</div>
                <p> Petsport Giant Tuff Balls, 4-inch - Extra thick natural rubber walls give extra durability and better bounce.Non-toxic-no chemical added for bounce like regular tennis balls.non-abrasive felt won't wear down dog's teeth like regular tennis balls.Colofast dye won't stain carpet like regular tennis balls.Industrial tennis balls made specially for dogs.</p>

            </div>

            <div class="preview" data-target="p-11">
                <i class="fas fa-times"></i>
                <img src="images/M-Pets_Dog_Collars.webp" alt="">
                <h3>M-Pets Dog Collars - Sportline Collar (Black)</h3>
                <div class="price">₹189</div>
                <p>Whether your dog looks best in something fancy or prefers something subtle, it’s important that your fur buddy always wears a collar and we have many at Petsy! It's the most obvious place to put ID tags in case your pup ever goes wandering. This beautiful M-Pets Dog Collars - Sportline Collar available on Petsy is versatile and easy to use! </p>

            </div>

            <div class="preview" data-target="p-12">
                <i class="fas fa-times"></i>
                <img src="images/ruffwear.webp" alt="">
                <h3>Ruffwear Harnesses For Dogs - Web Master</h3>
                <div class="price">₹5500</div>
                <p>The Web Master Harness is a secure, supportive, multi-use dog harness with a handle built for maneuvering and assisting dogs up and over obstacles. Thin, durable foam provides support without hindering range of motion and the high-coverage top panel offers a platform for attaching patches and signage for working dogs. </p>
            </div>

            <div class="preview" data-target="p-13">
                <i class="fas fa-times"></i>
                <img src="images/leashes.webp" alt="">
                <h3>For The Love Of Dogs - Extra Long Leashes</h3>
                <div class="price">₹1200</div>
                <p>Almost every dog loves to go on long walks, but does every parent enjoy the same? Dog collars and leashes are a crucial, yet often underestimated part of walktime. Like they say, there’s a leash for every dog, and a dog for every leash - dogs require different leashes at different stages of training. </p>
            </div>

            <div class="preview" data-target="p-14">
                <i class="fas fa-times"></i>
                <img src="images/Savic_Trotter.webp" alt="">
                <h3>Savic Trotter 1 Pet Carrier - Holds Up To 5kg</h3>
                <div class="price">₹2115</div>
                <p>Trotter 1 is a modern-shaped pet carrier, recommended for cats and small dogs weighing up to 5 kg.
                    L x W x H: 49cm x 33cm x 30cm
                    Load capacity: up to 5 kg
                </p>
            </div>

            <div class="preview" data-target="p-15">
                <i class="fas fa-times"></i>
                <img src="images/backpack.webp" alt="">
                <h3>Trixie Dan Backpack Pet Carrier </h3>
                <div class="price">₹5095</div>
                <p>
                    With waist strap for ideal weight distribution
                    stable in shape
                    Opens from the front
                    With net pocket
                    With integrated short leash
                    Padded bottom plate in lamb fur look (polyester), removable cover
                    Reflective parts
                    Polyester
                </p>
            </div>

            <div class="preview" data-target="p-16">
                <i class="fas fa-times"></i>
                <img src="images/m-pet_stroller.webp" alt="">
                <h3>M-Pets Aventura Pet Stroller (Black) </h3>
                <div class="price">₹21,149</div>
                <p>
                    Large opening and storage space
                    Easy quick folding system with one hand
                    Big wheels for more stability with a brake system
                    Front-wheel: 12" (30.48cm) (swivel 360), Rear wheel: 2 x 16" (40.6)
                    With cup holder
                    Ventilation window
                    Safety belt in the seat
                </p>
            </div>

        </div>

        <script src="dogs_script.js" defer></script>
    </div>
</body>

</html>