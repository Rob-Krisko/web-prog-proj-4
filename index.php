<?php
session_start();
$logged_in = isset($_SESSION["user_id"]);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project 4 Testing</title>
    <link rel="stylesheet" href="realestate.css">
  </head>
  <body>
    <header>
      <div class="header-content">
        <img src="logo1.png" alt="Boxed Estates Logo" class="logo">
        <h1>Boxed Estates</h1>
        <h2>Think inside the box for your luxury living experience</h2>
      </div>
      <nav>
        <?php
          if (session_status() == PHP_SESSION_NONE) {
              session_start();
          }

          if (isset($_SESSION["user_id"])) {
            // If the user is logged in
            echo '
              <a href="index.php">Home</a>
              <a href="' . ($_SESSION["user_type"] == "buyer" ? "buyer_dashboard.php" : ($_SESSION["user_type"] == "seller" ? "seller_dashboard.php" : "admin_dashboard.php")) . '">Dashboard</a>
              <a href="logout.php">Logout</a>
            ';
          } else {
            // If the user is not logged in
            echo '
              <a href="index.php">Home</a>
              <a href="#" id="register-modal-btn" class="register-link">Register</a>
              <a href="#" id="login-modal-btn" class="login-link">Login</a>
            ';
          }
          
          
        ?>
      </nav>
    </header>
    
    <main>
  <div class="container">
    <section class="carousel">
      <div class="carousel-item active">
        <img src="slide1.jpg" alt="Real Estate Listings">
      </div>
      <div class="carousel-item">
        <img src="slide2.jpg" alt="Personalized Assistance">
      </div>
      <div class="carousel-item">
        <img src="slide3.jpg" alt="Market Insights">
      </div>
      <div class="carousel-item">
        <img src="slide4.jpg" alt="Why Choose Us">
      </div>
      <div class="carousel-item">
        <img src="slide5.jpg" alt="CTA">
      </div>
      <button class="carousel-control prev">&#10094;</button>
      <button class="carousel-control next">&#10095;</button>
    </section>
  </div>
</main>

    
    <footer>
      <p>&copy; 2023 Boxed Estates. All rights reserved.</p>
    </footer>

    <!-- Registration and login modals -->
    <!-- Registration Modal -->
    <div id="register-modal" class="modal">
      <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Register</h2>
        <form id="register-form" method="post" action="register.php">
          <!-- Step 1: Basic registration info -->
          <div id="step1" class="registration-step">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="register-email">Email</label>
              <input type="email" id="register-email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="register-password">Password</label>
              <input type="password" id="register-password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
              <input type="checkbox" id="isSeller" name="isSeller">
              <label for="isSeller">I am a seller</label>
            </div>
            <button id="next1" class="next-btn">Next</button>
          </div>
          <!-- Step 2: Payment method -->
          <div id="step2" class="registration-step" style="display:none;">
            <p>Would you like to add a payment method?</p>
            <button id="noPayment">No</button>
            <button id="yesPayment">Yes</button>
          </div>
          <!-- Step 3: Credit card information -->
          <div id="step3" class="registration-step" style="display:none;">
            <div class="form-group">
              <label for="cardNumber">Card Number</label>
              <input type="text" id="cardNumber" name="cardNumber" class="form-control">
            </div>
            <div class="form-group">
              <label for="expiryDate">Expiry Date</label>
              <input type="text" id="expiryDate" name="expiryDate" class="form-control">
            </div>
            <div class="form-group">
              <label for="cvv">CVV</label>
              <input type="text" id="cvv" name="cvv" class="form-control">
            </div>
            <button type="submit" id="submitRegistration" class="submit-btn">Submit</button>
          </div>
        </form>
      </div>
    </div>


    <div id="login-modal" class="modal">
      <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Login</h2>
        <form action="login.php" method="POST">
          <label for="login-email">Email</label>
          <input type="email" id="login-email" name="email" required>
          <label for="login-password">Password</label>
          <input type="password" id="login-password" name="password" required>
          <button type="submit" class="submit-btn">Login</button>
        </form>
      </div>
    </div>

    <script src="realestate.js"></script>
  </body>
</html>
