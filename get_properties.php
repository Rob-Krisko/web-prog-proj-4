<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM properties";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $properties = array();
    while ($row = $result->fetch_assoc()) {
        array_push($properties, $row);
    }
    echo json_encode($properties);
} else {
    echo json_encode(array());
}

$conn->close();
?>
