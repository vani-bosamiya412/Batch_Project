<?php
include('connect.php');
header('Content-Type: application/json; charset=utf-8');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (empty($email) || empty($password) || empty($role)) {
    echo json_encode(['code' => 400, 'message' => 'Email, password, and role are required']);
    exit;
}

$stmt = $con->prepare("SELECT * FROM batch_users WHERE email = ? AND role = ?");
if (!$stmt) {
    echo json_encode(['code' => 500, 'message' => 'Database prepare failed']);
    exit;
}

$stmt->bind_param("ss", $email, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {

    if (password_verify($password, $user['password'])) {

        unset($user['password']); 
        echo json_encode([
            'code' => 200,
            'message' => 'Login successful',
            'user' => $user
        ]);

    } else {
        echo json_encode(['code' => 401, 'message' => 'Invalid email, password, or role']);
    }

} else {
    echo json_encode(['code' => 401, 'message' => 'Invalid email, password, or role']);
}
?>