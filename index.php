<?php
// Include the common header file which handles session_start(), db.php, and login status
require_once 'header.php';

// Fetch products (these queries are specific to the index page, so they remain here)
$stmt = $pdo->query("SELECT * FROM products LIMIT 8");
$products = $stmt->fetchAll();

$featuedQuary = $pdo->query("SELECT * FROM products WHERE isFeatured=1 LIMIT 4");
$featuredProducts = $featuedQuary->fetchAll();

$newArrivalQuary = $pdo->query("SELECT * FROM products WHERE isNewArrival=1 LIMIT 4");
$newProducts = $newArrivalQuary->fetchAll();
?>

<!-- Hero -->
<section id="hero">
  <h4>SneakerxStudio</h4>
  <h2>Heaven of Sneakers</h2>
  <h1>Shop the latest sneakers</h1>
  <p>A trustworthy shop for your next sneakers. Get the best deal with us.</p>
  <button>Shop Now</button>
</section>

<!-- Featured -->
<section id="product1" class="section-p1">
  <h2>Featured Product</h2>
  <p>Collection You Might Like</p>
  <div class="pro-container">
    <?php foreach ($featuredProducts as $product): ?>
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
        <a href="/ecom/detailPage.php?productid=<?=($product['product_id']) ?>"><i class="fal fa-shopping-cart cart"></i></a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- New Arrivals (reuse same set) -->
<section id="product1" class="section-p1">
  <h2>New Arrivals</h2>
  <p>Our latest collection</p>
  <div class="pro-container">
    <?php foreach ($newProducts as $product): ?>
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
        <a href="/ecom/detailPage.php?productid=1"><i class="fal fa-shopping-cart cart"></i></a>
      </div>
    <?php endforeach; ?>
  </div>
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
require_once 'footer.php';
?>
