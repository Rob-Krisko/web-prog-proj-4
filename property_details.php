<?php
if (!isset($_GET['id'])) {
  http_response_code(400);
  exit("Property ID is required.");
}

$propertyId = $_GET['id'];

// Database connection
$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM properties WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $propertyId);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

header("Content-Type: application/json");
echo json_encode($data);

$stmt->close();
$conn->close();
?>
