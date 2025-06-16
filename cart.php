<?php
session_start();
$host = 'localhost'; // or your host
$db   = 'ecommerce_demo'; // your database name
$user = 'root'; // your DB username
$pass = ''; // your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

// $user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT p.name, p.price, p.image_url, c.quantity, (p.price * c.quantity) AS subtotal
    FROM cart_items c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?
// ");
// $stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SneakersxStudio - Cart</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
</head>
<body>

<section id="header">
  <a href="index.php"><img src="/img/Logo.png" alt="Logo"></a>
  <div>
    <ul id="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="admin.php">Admin</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="blog.php">Blog</a></li>
        <li><a href="login.php">Log In</a></li>
        <li><a class="active" href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
        <li><a href="profile.php"><i class="fa fa-user"></i></a></li>
    </ul>
  </div>
</section>

<section id="cart" class="section-p1">
  <table width="100%">
    <thead>
      <tr>
        <td>Remove</td>
        <td>Image</td>
        <td>Product</td>
        <td>Price</td>
        <td>Quantity</td>
        <td>Subtotal</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($cart_items as $item): ?>
        <tr>
          <td><a href="#"><i class="far fa-time-circle"></i></a></td>
          <td><img src="<?= htmlspecialchars($item['image_url']) ?>" alt="product" width="60"></td>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td>$<?= number_format($item['price'], 2) ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>$<?= number_format($item['subtotal'], 2) ?></td>
        </tr>
        <?php $total += $item['subtotal']; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<section id="cart-add" class="section-p1">
  <div id="coupon">
    <h3>Apply Coupon</h3>
    <div>
      <input type="text" placeholder="Enter your Coupon">
      <button class="normal">Apply</button>
    </div>
  </div>
  <div id="subtotal">
    <h3>Cart Total</h3>
    <table>
      <tr>
        <td>Cart Subtotal</td>
        <td>$<?= number_format($total, 2) ?></td>
      </tr>
      <tr>
        <td>Shipping</td>
        <td>Free</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td><strong>$<?= number_format($total, 2) ?></strong></td>
      </tr>
    </table>
    <form action="checkout.php" method="POST">
      <button class="normal">Proceed to checkout</button>
    </form>
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
</footer>

</body>
</html>
