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

$sql = "SELECT p.* FROM properties p
        JOIN favorite_properties fp ON p.id = fp.property_id
        WHERE fp.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$result = $stmt->execute();

if ($result) {
    $properties = [];
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
    echo json_encode($properties);
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
