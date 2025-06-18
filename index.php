<?php
include 'includes/header.php';
?>



<section class="hero-banner">
  <img src="assets/images/golden-retriever.jpg" alt="Happy Pets" class="hero-image">
  <div class="hero-text">
    <h1>Welcome to the Pet Shop</h1>
    <p>Quality Food & Accessories for Dogs and Cats</p>
    <a href="products.php" class="btn">Shop Now</a>
  </div>
</section>


<section class="categories">
  <h2>Shop by Category</h2>
  <div class="category-grid">
    <div class="category-card">
      <img src="assets/images/himalayan-puppy-food.jpg" alt="Dog Food">
      <h3>Dog Food</h3>
    </div>
    <div class="category-card">
      <img src="assets/images/kong-goodie-bone.jpg" alt="Dog Food">
      <h3>Dog Accessories</h3>
    </div>
    <div class="category-card">
      <img src="assets/images/kittibles-kitten-food.jpg" alt="Cat Accessories">
      <h3>Cat Food</h3>
    </div>
    <div class="category-card">
      <img src="assets/images/litter-tray.jpg" alt="Cat Accessories">
      <h3>Cat Accessories</h3>
    </div>
  </div>
</section>


<?php if (isset($_SESSION['just_logged_out'])): ?>
  <script>
    // Clear saved quantity values from localStorage on logout
    for (let key in localStorage) {
      if (key.startsWith("qty_")) {
        localStorage.removeItem(key);
      }
    }
  </script>
  <?php unset($_SESSION['just_logged_out']); ?>
<?php endif; ?>

<section class="pet-gallery">
  <h2>Pet Moments </h2>
  <div class="gallery-grid">
    <img src="assets/images/side-eye-dog.jpg" alt="Cute Dog">
    <img src="assets/images/cat-sleeping.jpg" alt="Cat Sleeping">
    <img src="assets/images/dog-playing.jpg" alt="Dog with Toy">
    <img src="assets/images/cat-playing.jpg" alt="Cat Playing">
  </div>
</section>


<?php include 'includes/footer.php'; ?>