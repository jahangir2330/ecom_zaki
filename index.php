<?php
// Start a session at the very beginning of the script
session_start();
require_once 'db.php';
// Fetch products
$stmt = $pdo->query("SELECT * FROM products LIMIT 8");
$products = $stmt->fetchAll();


$featuedQuary = $pdo->query("SELECT * FROM products WHERE isFeatured=1 LIMIT 4");
$featuredProducts = $featuedQuary->fetchAll();


$newArrivalQuary = $pdo->query("SELECT * FROM products WHERE isNewArrival=1 LIMIT 4");
$newProducts = $newArrivalQuary->fetchAll();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : '';
$userType = $isLoggedIn ? ($_SESSION['user_type'] ?? 'customer') : ''; // Default to 'customer' if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sneakersx Studio</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>

<!-- Header -->
<section id="header">
  <a href="index.php"><img src="img/Logo.png" alt="Logo"></a>
  <div>
    <ul id="navbar">
      <li><a class="active" href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <?php if ($userType === 'admin'): // Show admin link only if user is admin ?>
      <li><a href="admin.html">Admin</a></li>
      <?php endif; ?>
      <li><a href="aboutUS.html">About</a></li>
      <li><a href="blog.html">Blog</a></li>
      
      <?php if ($isLoggedIn): // If logged in, show profile icon and logout ?>
      <li class="dropdown">
        <a href="profile.php" class="profile-link">
          <i class="fa fa-user"></i> <?php echo $username; ?>
        </a>
        <div class="dropdown-content">
          <a href="profile.php">My Profile</a>
          <a href="logout.php">Logout</a>
        </div>
      </li>
      <?php else: // If not logged in, show login link ?>
      <li><a href="login.php">Log In</a></li>
      <?php endif; ?>
      
      <li><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
      <!-- Removed duplicate profile link, replaced by conditional display -->
    </ul>
  </div>
</section>

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

<!-- Footer -->
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

<script src="js/script.js"></script>
</body>
</html>
