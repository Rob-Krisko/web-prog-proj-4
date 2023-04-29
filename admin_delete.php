<?php

    $delete = $_POST['id'];
    $sql = "DELETE FROM properties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete);
    $result = $stmt->execute();
    if ($result) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }

    header('./admin_dashboard.php');


?>