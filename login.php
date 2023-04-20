<?php
session_start();

$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT id, password, user_type FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_type"] = $row["user_type"];

        // Redirect users based on their user type
        if ($row["user_type"] == "buyer") {
            header("Location: buyer_dashboard.php");
        } elseif ($row["user_type"] == "seller") {
            header("Location: seller_dashboard.php");
        } elseif ($row["user_type"] == "admin") {
            header("Location: admin_dashboard.html");
        } else {
            header("Location: index.php");
        }


    } else {
        echo "Incorrect password";
    }
} else {
    echo "Username not found";
}

$conn->close();
?>
