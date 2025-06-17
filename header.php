<?php
// Start a session at the very beginning of the script for all pages
if (session_status() == PHP_SESSION_NONE) { // Prevent session_start() if already started
    session_start();
}

// Include database connection. Make sure db.php is in the same directory.
// This ensures $pdo is available on all pages including this header.
require_once 'db.php';

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
  <!-- You can add common JS includes here if needed for all pages -->
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
    </ul>
  </div>
</section>

<!-- Main content will go here in the individual pages -->
