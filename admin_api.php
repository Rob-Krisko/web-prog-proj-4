<?php
header("Content-Type: application/json");

// Replace these with your database connection details
$dbHost = "localhost";
$dbUser = "rkrisko1";
$dbPassword = "rkrisko1";
$dbName = "rkrisko1";

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == "get_analytics_data") {
        $totalUsersQuery = "SELECT COUNT(*) as total_users FROM boxed_users";
        $totalUsersResult = $conn->query($totalUsersQuery);
        $totalUsers = $totalUsersResult->fetch_assoc()["total_users"];

        $totalPropertiesQuery = "SELECT COUNT(*) as total_properties FROM properties";
        $totalPropertiesResult = $conn->query($totalPropertiesQuery);
        $totalProperties = $totalPropertiesResult->fetch_assoc()["total_properties"];

        $averagePropertyPriceQuery = "SELECT AVG(price) as average_price FROM properties";
        $averagePropertyPriceResult = $conn->query($averagePropertyPriceQuery);
        $averagePropertyPrice = (float) $averagePropertyPriceResult->fetch_assoc()["average_price"];
    
        $analyticsData = [
            "total_users" => $totalUsers,
            "total_properties" => $totalProperties,
            "average_property_price" => $averagePropertyPrice
        ];
    
        echo json_encode($analyticsData);
    }

    if ($action == "get_properties") {
        $propertiesQuery = "SELECT * FROM properties";
        $propertiesResult = $conn->query($propertiesQuery);
        $properties = [];

        while ($row = $propertiesResult->fetch_assoc()) {
            $properties[] = $row;
        }

        echo json_encode($properties);
    }

    if ($action == "get_users") {
        $usersQuery = "SELECT * FROM boxed_users";
        $usersResult = $conn->query($usersQuery);
        $users = [];

        while ($row = $usersResult->fetch_assoc()) {
            $users[] = $row;
        }

        echo json_encode($users);
    }

    if ($action == "delete_user") {
        if (isset($_GET['user_id'])) {
            $userId = $_GET['user_id'];
            $deleteUserQuery = "DELETE FROM boxed_users WHERE id = ?";
            $stmt = $conn->prepare($deleteUserQuery);
            $stmt->bind_param("i", $userId);
    
            if ($stmt->execute()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false]);
            }
    
            $stmt->close();
        } else {
            echo json_encode(["success" => false]);
        }
    }
    if ($action == "delete_property") {
        if (isset($_GET['property_id'])) {
            $propertyId = $_GET['property_id'];
            $deletePropertyQuery = "DELETE FROM properties WHERE id = ?";
            $stmt = $conn->prepare($deletePropertyQuery);
            $stmt->bind_param("i", $propertyId);
    
            if ($stmt->execute()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false]);
            }
    
            $stmt->close();
        } else {
            echo json_encode(["success" => false]);
        }
    }
}

$conn->close();
?>
