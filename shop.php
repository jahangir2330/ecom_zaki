<?php
// Include the common header file which handles session_start(), db.php, and login status
// This line replaces:
// session_start();
// require_once 'db.php';
// The entire <head> section
// The entire <section id="header">
require_once 'header.php';

// Fetch all products (these queries are specific to the shop page, so they remain here)
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!-- Content specific to the Shop Page -->
<section id="page-header" class="section-p1"> <!-- Added section-p1 class for consistent padding -->
  <h2>#ShopNow</h2>
  <p>Our Full Collection</p>
</section>

<section id="product1" class="section-p1">
  <h2>All Products</h2>
  <p>Our Full Collection</p>
  <div class="pro-container">
    <?php foreach ($products as $product): ?>
      <div class="pro">
        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="product">
        <div class="des">
          <span><?= htmlspecialchars($product['name']) ?></span>
          <h5><?= htmlspecialchars($product['description']) ?></h5>
          <div class="star">
            <?php for ($i = 0; $i < 5; $i++): ?>
              <i class="fas fa-star"></i>
            <?php endfor; ?>
          </div>
          <h4>$<?= number_format($product['price'], 2) ?></h4>
        </div>
        <a href="#"><i class="fal fa-shopping-cart cart"></i></a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section id="pagination" class="section-p1 section-m1">
  <a href="#">1</a>
  <a href="#">2</a>
  <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
</section>

<section id="newsletter" class="section-p1 section-m1">
  <div class="newstext">
    <h4>Sign Up For Newsletter</h4>
    <p>Get E-mail updates about our latest shop and <span>Special Offers.</span></p>
  </div>
  <div class="form">
    <input type="text" placeholder="Your E-mail address">
    <button class="normal">Sign Up</button>
  </div>
</section>

<?php
// Include the common footer file
// This line replaces the entire <footer> section and closing </body>, </html> tags.
require_once 'footer.php';
?>
