<?php

require_once 'db.php';

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SneakersxStudio</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>

<section id="header">
  <a href="index.php"><img src="/img/Logo.png" alt="Logo"></a>
  <div>
    <ul id="navbar">
      <li><a href="index.php">Home</a></li>
      <li><a class="active" href="shop.php">Shop</a></li>
      <li><a href="admin.html">Admin</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="blog.html">Blog</a></li>
      <li><a href="login.html">Log In</a></li>
      <li><a href="cart.html"><i class="far fa-shopping-bag"></i></a></li>
      <li><a href="profile.html"><i class="fa fa-user"></i></a></li>
    </ul>
  </div>
</section>

<section id="page-header">
  <h2>SneakerxStudio</h2>
  <p>#Heaven of Sneakers</p>
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

<footer class="section-p1">
  <div class="col">
    <h4>Contact</h4>
    <p><strong>Email:</strong> s4125820@student.rmit.edu.au, s4043058@student.rmit.edu.au</p>
    <p><strong>Email:</strong> s4061087@student.rmit.edu.au, s4088056@student.rmit.edu.au</p>
    <p><strong>Location:</strong> Melbourne, Australia</p>
    <div class="follow">
      <h4>Follow Us</h4>
      <div class="icon">
        <i class="fab fa-facebook-f"></i>
        <i class="fab fa-twitter"></i>
        <i class="fab fa-instagram"></i>
        <i class="fab fa-pinterest-p"></i>
        <i class="fab fa-youtube"></i>
      </div>
    </div>
  </div>
  <div class="col">
    <h4>About</h4>
    <a href="#">About Us</a>
    <a href="#">Delivery Information</a>
    <a href="#">Privacy Policy</a>
    <a href="#">Terms & Conditions</a>
    <a href="#">Contact Us</a>
  </div>
  <div class="col">
    <h4>My Account</h4>
    <a href="#">Sign In</a>
    <a href="#">View Cart</a>
    <a href="#">My Wishlist</a>
    <a href="#">Track My Order</a>
    <a href="#">Help</a>
  </div>
</footer>

<script src="script.js"></script>
</body>
</html>
