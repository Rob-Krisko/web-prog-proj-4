<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "seller") {
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

$propertyId = $_POST["property_id"];
$address = $_POST["address"];
$price = $_POST["price"];
$bedrooms = $_POST["bedrooms"];
$bathrooms = $_POST["bathrooms"];
$type = $_POST["type"];
$area = $_POST["area"];
$year_built = $_POST["year_built"];
$description = $_POST["description"];

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $image = $_FILES["image"];
    $target_dir = "property_images/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a real image
    $check = getimagesize($image["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($image["size"] > 500000) {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $sql = "UPDATE properties SET image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $image["name"], $propertyId);
            $stmt->execute();
        }
    }
}

$sql = "UPDATE properties SET address = ?, price = ?, bedrooms = ?, bathrooms = ?, property_type = ?, sqft = ?, year_built = ?, description = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiisiiisi", $address, $price, $bedrooms, $bathrooms, $type, $area, $year_built, $description, $propertyId, $userId);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
