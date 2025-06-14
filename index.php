<?php
include 'includes/header.php';
?>

<h1>🐾 Welcome to the Pet Shop</h1>
<p>Your one-stop shop for quality food & accessories for dogs and cats.</p>

<section class="homepage-actions">
  <a href="products.php" class="btn">Browse All Products</a>
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

<?php include 'includes/footer.php'; ?>