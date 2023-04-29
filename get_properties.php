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
$bedrooms = isset($_GET['bedrooms']) ? json_decode($_GET['bedrooms']) : array();
$bathrooms = isset($_GET['bathrooms']) ? json_decode($_GET['bathrooms']) : array();
$currentPage = isset($_GET['currentPage']) ? intval($_GET['currentPage']) : 1;
$itemsPerPage = isset($_GET['itemsPerPage']) ? intval($_GET['itemsPerPage']) : 10;

$sql = "SELECT * FROM properties WHERE (price >= $minPrice AND price <= $maxPrice) ";

if ($search != '') {
    $sql .= "AND (address LIKE '%$search%' OR description LIKE '%$search%') ";
}

if ($homeType != '' && $homeType != 'Any') {
    $sql .= "AND property_type = '$homeType' ";
}

if (!empty($bedrooms)) {
    $sql .= "AND bedrooms IN (" . implode(',', $bedrooms) . ") ";
}

if (!empty($bathrooms)) {
    $sql .= "AND bathrooms IN (" . implode(',', $bathrooms) . ") ";
}

// First, fetch the total number of properties that match the filters
$sqlCount = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
$sqlCount = preg_replace("/LIMIT\\s+\\d+\\s+OFFSET\\s+\\d+$/i", "", $sqlCount);
$countResult = $conn->query($sqlCount);
$totalItems = $countResult->fetch_assoc()["total"];

$offset = ($currentPage - 1) * $itemsPerPage;
$sql .= "LIMIT $itemsPerPage OFFSET $offset";

$result = $conn->query($sql);

if (!$result) {
    header('Content-Type: application/json', true, 500);
    echo "Error executing SQL query: " . $conn->error;
    $conn->close();
    exit();
}

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Prepare the response
$response = array(
    'properties' => $data,
    'totalItems' => $totalItems
);

header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);

$conn->close();
?>
