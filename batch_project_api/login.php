<?php
include('connect.php');
header('Content-Type: application/json; charset=utf-8');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['code' => 400, 'message' => 'Email and password required']);
    exit;
}

$stmt = $con->prepare("SELECT * FROM batch_users WHERE email = ?");
if (!$stmt) {
    echo json_encode(['code' => 500, 'message' => 'Database prepare failed']);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    error_log("Input password: " . $password);
    error_log("Stored hash: " . $user['password']);
    error_log("Verify result: " . (password_verify($password, $user['password']) ? 'true' : 'false'));

    if (password_verify($password, $user['password'])) {
        unset($user['password']); 
        echo json_encode(['code' => 200, 'message' => 'Login successful', 'user' => $user]);
    } else {
        echo json_encode(['code' => 401, 'message' => 'Invalid email or password']);
    }
} else {
    echo json_encode(['code' => 401, 'message' => 'Invalid email or password']);
}
?>