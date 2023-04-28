<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_seller = isset($_POST['isSeller']) ? 1 : 0;
    $card_type = isset($_POST['cardType']) ? $_POST['cardType'] : "";
    $card_number = isset($_POST['cardNumber']) ? $_POST['cardNumber'] : "";
    $card_expiry = isset($_POST['expiryDate']) ? $_POST['expiryDate'] : "";
    $card_cvv = isset($_POST['cvv']) ? $_POST['cvv'] : "";

    // Validate the form data
    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    // Check if email is already registered
    $sql = "SELECT * FROM boxed_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Email is already registered.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Determine the user type
    if ($is_seller) {
        $user_type = "seller";
    } else {
        $user_type = "buyer";
    }

    // Insert the data into the MySQL database
    $sql = "INSERT INTO boxed_users (`name`, `email`, `password`, `is_seller`, `is_admin`, `card_type`, `card_number`, `card_expiry`, `card_cvv`) VALUES (?, ?, ?, ?, 0, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // If the statement preparation failed, print the error message
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("sssissss", $name, $email, $hashed_password, $is_seller, $card_type, $card_number, $card_expiry, $card_cvv);
    $result = $stmt->execute();

    if ($result) {
        echo "success";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
        error_log($error_message);
        echo $error_message;
    }
    

    $stmt->close();
}

$conn->close();
?>
