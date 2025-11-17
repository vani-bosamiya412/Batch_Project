<?php
include "connect.php";
header('Content-Type: application/json; charset=utf-8');

$email = $_POST['email'] ?? '';

if (empty($email)) {
    echo json_encode(['code' => 400, 'message' => 'Email required']);
    exit;
}

$stmt = $con->prepare("SELECT id, email FROM batch_users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {

    $check = $con->prepare("SELECT id FROM forgot_requests WHERE user_id = ? AND status = 'pending'");
    $check->bind_param("i", $user['id']);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode(['code' => 409, 'message' => 'A pending request already exists']);
        exit;
    }

    $insert = $con->prepare("INSERT INTO forgot_requests (user_id, email) VALUES (?, ?)");
    $insert->bind_param("is", $user['id'], $user['email']);
    $insert->execute();

    echo json_encode(['code' => 200, 'message' => 'Admin has been notified']);
} else {
    echo json_encode(['code' => 404, 'message' => 'User not found']);
}
?>