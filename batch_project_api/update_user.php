<?php
include "connect.php";

$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$role = $_POST['role'] ?? '';
$email = $_POST['email'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';

if ($id) {
    $stmt = $con->prepare("
        UPDATE batch_users 
        SET name = ?, role = ?, email = ?, phone_number = ?
        WHERE id = ?
    ");

    $stmt->bind_param("ssssi", $name, $role, $email, $phone_number, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "User updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User ID required"]);
}
?>