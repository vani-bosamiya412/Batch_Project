<?php
include "connect.php";
header('Content-Type: application/json; charset=utf-8');

$request_id = $_POST['request_id'] ?? '';
$new_password = $_POST['new_password'] ?? '';

if (empty($request_id) || empty($new_password)) {
    echo json_encode(['code' => 400, 'message' => 'Request ID and new password required']);
    exit;
}

$stmt = $con->prepare("SELECT user_id FROM forgot_requests WHERE id = ? AND status = 'pending'");
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$req = $result->fetch_assoc()) {
    echo json_encode(['code' => 404, 'message' => 'Invalid request']);
    exit;
}

$user_id = $req['user_id'];
$hashed = password_hash($new_password, PASSWORD_BCRYPT);

$update = $con->prepare("UPDATE batch_users SET password = ? WHERE id = ?");
$update->bind_param("si", $hashed, $user_id);
$update->execute();

$update_req = $con->prepare("UPDATE forgot_requests SET status = 'completed' WHERE id = ?");
$update_req->bind_param("i", $request_id);
$update_req->execute();

echo json_encode(['code' => 200, 'message' => 'Password updated successfully']);
?>