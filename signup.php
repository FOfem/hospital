<?php
header("Content-Type: application/json");
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $first_name   = trim($_POST['first_name'] ?? '');
    $surname      = trim($_POST['surname'] ?? '');
    $other_name   = trim($_POST['other_name'] ?? '');
    $address      = trim($_POST['address'] ?? '');
    $gender       = $_POST['gender'] ?? '';
    $phone_number = trim($_POST['phone_number'] ?? '');
    $guidance     = trim($_POST['guidance'] ?? '');

    // 1. Basic Validation
    if (empty($first_name) || empty($surname) || empty($address) || empty($phone_number)) {
        echo json_encode(["status" => "error", "message" => "Required fields are missing."]);
        exit;
    }

    try {
        // 2. Prepare SQL statement
        $sql = "INSERT INTO users (first_name, surname, other_name, address, gender, phone_number, guidance) 
                VALUES (:first_name, :surname, :other_name, :address, :gender, :phone_number, :guidance)";
        
        $stmt = $pdo->prepare($sql);

        // 3. Bind and Execute
        $stmt->execute([
            ':first_name'   => htmlspecialchars($first_name),
            ':surname'      => htmlspecialchars($surname),
            ':other_name'   => htmlspecialchars($other_name),
            ':address'      => htmlspecialchars($address),
            ':gender'       => $gender,
            ':phone_number' => htmlspecialchars($phone_number),
            ':guidance'     => htmlspecialchars($guidance)
        ]);

        echo json_encode(["status" => "success", "message" => "User registered successfully!"]);

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry error code
            echo json_encode(["status" => "error", "message" => "Phone number already exists."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
