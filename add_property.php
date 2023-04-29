<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
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

$userId = $_SESSION["user_id"];
$address = $_POST["address"];
$price = $_POST["price"];
$bedrooms = $_POST["bedrooms"];
$bathrooms = $_POST["bathrooms"];
$type = strtolower($_POST["type"]); // Convert type to lowercase
$area = $_POST["area"] ?? "";
$year_built = $_POST["year_built"] ?? "";
$description = $_POST["description"] ?? "";

$imageName = "";
if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $imageName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetDir = "property_images/";
    $targetFile = $targetDir . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    chmod($targetFile, 0644); // Set the permissions of the uploaded file
}

$sql = "INSERT INTO properties (user_id, address, price, bedrooms, bathrooms, image, property_type, sqft, year_built, description)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error preparing the statement: " . $conn->error;
    exit;
}

$stmt->bind_param("isdiisssss", $userId, $address, $price, $bedrooms, $bathrooms, $imageName, $type, $area, $year_built, $description);

if (!$stmt->execute()) {
    echo "Error executing the statement: " . $stmt->error;
    exit;
}

$stmt->close();
$conn->close();

header("Location: seller_dashboard.php");
?>
