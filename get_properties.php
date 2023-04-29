<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "rkrisko1";
$password = "rkrisko1";
$dbname = "rkrisko1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$homeType = isset($_GET['homeType']) ? $_GET['homeType'] : '';
$minPrice = isset($_GET['minPrice']) ? intval($_GET['minPrice']) : 0;
$maxPrice = isset($_GET['maxPrice']) ? intval($_GET['maxPrice']) : PHP_INT_MAX;
$bedrooms = isset($_GET['bedrooms']) ? $_GET['bedrooms'] : '';
$bathrooms = isset($_GET['bathrooms']) ? $_GET['bathrooms'] : '';
$currentPage = isset($_GET['currentPage']) ? intval($_GET['currentPage']) : 1;
$itemsPerPage = isset($_GET['itemsPerPage']) ? intval($_GET['itemsPerPage']) : 10;

$sql = "SELECT * FROM properties WHERE (price >= $minPrice AND price <= $maxPrice) ";

if ($search != '') {
    $sql .= "AND (address LIKE '%$search%' OR description LIKE '%$search%') ";
}

if ($homeType != '' && $homeType != 'Any') {
    $sql .= "AND property_type = '$homeType' ";
}

if ($bedrooms != '') {
    $sql .= "AND bedrooms IN (" . implode(',', array_map('intval', explode(',', $bedrooms))) . ") ";
}

if ($bathrooms != '') {
    $sql .= "AND bathrooms IN (" . implode(',', array_map('intval', explode(',', $bathrooms))) . ") ";
}

$offset = ($currentPage - 1) * $itemsPerPage;
$sql .= "LIMIT $itemsPerPage OFFSET $offset";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);

$conn->close();
?>
