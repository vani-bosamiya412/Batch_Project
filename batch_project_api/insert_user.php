<?php
include "connect.php";

$name = $_POST['name'] ?? '';
$role = $_POST['role'] ?? '';
$email = $_POST['email'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
$password = $_POST['password'] ?? '';

if ($name && $role && $email && $phone_number && $password) {
    $check = $con->prepare("SELECT id FROM batch_users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists"]);
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $con->prepare("INSERT INTO batch_users (name, role, email, phone_number, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $role, $email, $phone_number, $password_hash);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "User inserted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Insert failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
}
?>