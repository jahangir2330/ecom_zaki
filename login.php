<?php
// Start a session at the very beginning of the script
session_start();

// Include database connection or configuration if it's in a separate file
// For example: include 'config/database.php';
// You would define your database connection (e.g., using PDO or mysqli) here or in an included file.

// --- Handle Sign Up Form Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup_submit"])) {
    $firstName = htmlspecialchars(trim($_POST["first_name"]));
    $lastName = htmlspecialchars(trim($_POST["last_name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = $_POST["password"]; // Password will be hashed later, so no htmlspecialchars here yet.
    $captchaSignup = htmlspecialchars(trim($_POST["captcha_signup"]));
    $submittedCaptcha = htmlspecialchars(trim($_SESSION['captcha_signup']));
    $submittedCaptcha = htmlspecialchars(trim($_POST["submitted_captcha_signup"])); // Assuming you have a hidden field or similar for the generated CAPTCHA

    $errors = [];

    // Basic server-side validation
    if (empty($firstName)) {
        $errors[] = "First name is required.";
    }
    if (empty($lastName)) {
        $errors[] = "Last name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($password) || strlen($password) < 3) { // Example: minimum 8 characters
        $errors[] = "Password must be at least 3 characters long.";
    }
    // CAPTCHA validation (you'd generate and store this on the server-side)
    // For now, a placeholder:
    if (strtolower($captchaSignup) !== strtolower($submittedCaptcha)) { // Compare against actual generated captcha
         $errors[] = "CAPTCHA for signup is incorrect.";
    }


    if (empty($errors)) {
        // --- PHP logic for database interaction, session management, and validation ---
        // 1. Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 2. Insert new user into the 'users' table (using your ecommerce_demo.sql structure)
        // Example (using PDO - assumes $pdo is your database connection object):
        /**/
        try {
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password_hash, user_type) VALUES (?, ?, ?, ?, 'customer')");
            $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);

            // Registration successful!
            $_SESSION['message'] = "Registration successful! Please log in.";
            // Redirect to login page or a success page
            header("Location: login.php?registered=true");
            exit();

        } catch (PDOException $e) {
            $errors[] = "Registration failed: " . $e->getMessage();
            // Log the error: error_log("Registration Error: " . $e->getMessage());
        }
        
        // For demonstration, let's just show a success message
        $_SESSION['message'] = "Signup successful! (No database interaction in this demo)";
         header("Location: login.php?signup_success=true");
         exit();

    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input'] = $_POST; // Keep form data for re-population
        // Redirect back to display errors, or keep them for display on the current page
        // header("Location: login.php?error=signup"); // You might use a query param or just re-display on same page
    }
}

// --- Handle Log In Form Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_submit"])) {
    $email = htmlspecialchars(trim($_POST["login_email"]));
    $password = $_POST["login_password"];
    $captchaLogin = htmlspecialchars(trim($_POST["captcha_login"]));
    $submittedCaptcha = htmlspecialchars(trim($_POST["submitted_captcha_login"])); // Assuming you have a hidden field or similar for the generated CAPTCHA

    $errors = [];

    // Basic server-side validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required for login.";
    }
    if (empty($password)) {
        $errors[] = "Password is required for login.";
    }
    // CAPTCHA validation (you'd generate and store this on the server-side)
    if (strtolower($captchaLogin) !== strtolower($submittedCaptcha)) { // Compare against actual generated captcha
         $errors[] = "CAPTCHA for login is incorrect.";
    }
    

    if (empty($errors)) {
        // --- PHP logic for database interaction, session management, and validation ---
        // 1. Fetch user from 'users' table by email
        /*
        try {
            $stmt = $pdo->prepare("SELECT user_id, email, password_hash, user_type FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Login successful!
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['loggedin'] = true;

                // Redirect to dashboard or home page
                header("Location: index.php"); // Or whatever your main page is
                exit();
            } else {
                $errors[] = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $errors[] = "Login failed: " . $e->getMessage();
            // Log the error: error_log("Login Error: " . $e->getMessage());
        }
        */
         // For demonstration, let's just show an error message
         $errors[] = "Invalid email or password (No database interaction in this demo).";

    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input_login'] = ['email' => $email]; // Keep email for re-population
        // Redirect back to display errors, or keep them for display on the current page
        // header("Location: login.php?error=login"); // You might use a query param
    }
}

// Generate a new CAPTCHA for each page load or form display
// You'd want to store this in a session variable to verify against later.
function generateCaptcha() {
    $chars = 'abcdefghijkmnpqrstuvwxyz23456789';
    $captcha = '';
    for ($i = 0; $i < 6; $i++) {
        $captcha .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $captcha;
}

$signupCaptcha = generateCaptcha();
$_SESSION['signup_captcha'] = $signupCaptcha; // Store it for verification

$loginCaptcha = generateCaptcha();
$_SESSION['login_captcha'] = $loginCaptcha; // Store it for verification

// Display any messages or errors
$displayMessage = '';
$displayErrors = [];

if (isset($_SESSION['message'])) {
    $displayMessage = $_SESSION['message'];
    unset($_SESSION['message']); // Clear message after displaying
}
if (isset($_SESSION['errors'])) {
    $displayErrors = $_SESSION['errors'];
    unset($_SESSION['errors']); // Clear errors after displaying
}

// Retrieve old input for repopulating forms
$oldSignupInput = isset($_SESSION['old_input']) ? $_SESSION['old_input'] : [];
unset($_SESSION['old_input']);

$oldLoginInput = isset($_SESSION['old_input_login']) ? $_SESSION['old_input_login'] : [];
unset($_SESSION['old_input_login']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sneaker'X Studio Login</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <?php if (!empty($displayMessage)): ?>
      <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px; text-align: center;">
          <?php echo $displayMessage; ?>
      </div>
  <?php endif; ?>

  <?php if (!empty($displayErrors)): ?>
      <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px;">
          <ul>
              <?php foreach ($displayErrors as $error): ?>
                  <li><?php echo htmlspecialchars($error); ?></li>
              <?php endforeach; ?>
          </ul>
      </div>
  <?php endif; ?>

  <script src="js/script.js"></script>
  <div class="container">
    <h1 class="logo">Sneaker'X Studio </h1>

    <div class="form-box">
      <div class="tabs">
        <button id="show-signup" class="active">Sign Up</button>
        <button id="show-login">Log In</button>
      </div>

      <form class="signup-form auth-form" method="POST" action="login.php">
        <h2>Sign Up</h2>
        <input type="text" name="first_name" placeholder="First Name*" required value="<?php echo htmlspecialchars($oldSignupInput['first_name'] ?? ''); ?>" />
        <input type="text" name="last_name" placeholder="Last Name*" required value="<?php echo htmlspecialchars($oldSignupInput['last_name'] ?? ''); ?>" />
        <input type="email" name="email" placeholder="Email Address*" required value="<?php echo htmlspecialchars($oldSignupInput['email'] ?? ''); ?>" />

        <div class="password-box">
          <input type="password" name="password" placeholder="Password*" required />
          <i class="fas fa-eye-slash toggle-password"></i>
        </div>

        <div class="captcha-box">
          <label for="captcha-signup">Solve CAPTCHA:</label>
          <div class="captcha-display" id="captcha-signup-text"><?php echo htmlspecialchars($signupCaptcha); ?></div>
          <input type="text" id="captcha-signup" name="captcha_signup" placeholder="Enter CAPTCHA here" required />
          <!-- <input type="hidden" name="submitted_captcha_signup" value="<?php echo htmlspecialchars($_SESSION['signup_captcha']); ?>" /> -->
        </div>

        <button type="submit" name="signup_submit" class="submit-btn">Sign Up</button>
        <div class="divider">OR</div>
        <p class="social-label">Sign up with</p>
        <div class="social-icons">
          <button><i class="fab fa-google"></i></button>
          <button><i class="fab fa-apple"></i></button>
          <button><i class="fab fa-facebook-f"></i></button>
        </div>
        <p class="login-link">Already have an account? <a href="#" id="switch-login">Log In</a></p>
      </form>

      <form class="login-form auth-form hidden" method="POST" action="login.php">
        <h2>Log In</h2>
        <input type="email" name="login_email" placeholder="Email Address*" required value="<?php echo htmlspecialchars($oldLoginInput['email'] ?? ''); ?>" />
        <div class="password-box">
          <input type="password" name="login_password" placeholder="Password*" required />
          <i class="fas fa-eye-slash toggle-password"></i>
        </div>

        <div class="captcha-box">
          <label for="captcha-login">Solve CAPTCHA:</label>
          <div class="captcha-display" id="captcha-login-text"><?php echo htmlspecialchars($loginCaptcha); ?></div>
          <input type="text" id="captcha-login" name="captcha_login" placeholder="Enter CAPTCHA here" required />
          <input type="hidden" name="submitted_captcha_login" value="<?php echo htmlspecialchars($_SESSION['login_captcha']); ?>" />
        </div>

        <button type="submit" name="login_submit" class="submit-btn">Log In</button>
        <div class="divider">OR</div>
        <p class="social-label">Log in with</p>
        <div class="social-icons">
          <button><i class="fab fa-google"></i></button>
          <button><i class="fab fa-apple"></i></button>
          <button><i class="fab fa-facebook-f"></i></button>
        </div>
        <p class="login-link">Don't have an account? <a href="#" id="switch-signup">Sign Up</a></p>
      </form>
    </div>
  </div>
</body>
</html>