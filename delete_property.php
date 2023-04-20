<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "seller") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $propertyId = intval($_POST["propertyId"]);

    $servername = "localhost";
    $username = "rkrisko1";
    $password = "rkrisko1";
    $dbname = "rkrisko1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION["user_id"];
    $sql = "DELETE FROM properties WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $propertyId, $userId);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }

    $stmt->close();
    $conn->close();
}
?>
