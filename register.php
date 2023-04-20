<?php
$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_type = $_POST["user_type"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$card_name = isset($_POST["card_name"]) ? $_POST["card_name"] : NULL;
$card_type = isset($_POST["card_type"]) ? $_POST["card_type"] : NULL;
$card_number = isset($_POST["card_number"]) ? $_POST["card_number"] : NULL;
$expiration_date = isset($_POST["expiration_date"]) ? $_POST["expiration_date"] : NULL;
$coupon = isset($_POST["coupon"]) ? $_POST["coupon"] : NULL;
$address = isset($_POST["address"]) ? $_POST["address"] : NULL;
$billing_address = isset($_POST["billing_address"]) ? $_POST["billing_address"] : NULL;
$phone = isset($_POST["phone"]) ? $_POST["phone"] : NULL;

$sql = "INSERT INTO users (user_type, first_name, last_name, email, username, password, card_name, card_type, card_number, expiration_date, coupon, address, billing_address, phone) VALUES ('$user_type', '$first_name', '$last_name', '$email', '$username', '$password', '$card_name', '$card_type', '$card_number', '$expiration_date', '$coupon', '$address', '$billing_address', '$phone')";

if ($conn->query($sql) === TRUE) {
  header("Location: login.html");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
