<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];
$property_id = $_POST["property_id"];
$action = $_POST["action"];

if ($action == "add") {
    $sql = "INSERT INTO favorite_properties (user_id, property_id) VALUES (?, ?)";
} else if ($action == "remove") {
    $sql = "DELETE FROM favorite_properties WHERE user_id = ? AND property_id = ?";
} else {
    header("HTTP/1.1 400 Bad Request");
    exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $property_id);
$result = $stmt->execute();

if ($result) {
    echo "Success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
