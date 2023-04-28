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
    <link rel="stylesheet" href="head.css">
    <link rel="stylesheet" href="dashboard.css">
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
              <a href="' . ($_SESSION["user_type"] == "buyer" ? "buyer_dashboard.php" : ($_SESSION["user_type"] == "seller" ? "seller_dashboard.php" : "admin_dashboard.html")) . '">Dashboard</a>
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
