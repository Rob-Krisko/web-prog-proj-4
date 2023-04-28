<?php
session_start();

// Replace these values with your actual database credentials
$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT id, name, password, is_seller, is_admin FROM boxed_users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();

  // Verify the hashed password
  if (password_verify($password, $user["password"])) {
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["name"] = $user["name"];
    
    if ($user["is_admin"]) {
      $_SESSION["user_type"] = "admin";
      header("Location: admin_dashboard.php");
      exit();
    } elseif ($user["is_seller"]) {
      $_SESSION["user_type"] = "seller";
      header("Location: seller_dashboard.php");
      exit();
    } else {
      $_SESSION["user_type"] = "buyer";
      header("Location: buyer_dashboard.php");
      exit();
    }
  } else {
    echo "Invalid password.";
  }
} else {
  echo "User not found.";
}

$stmt->close();
$conn->close();
?>
