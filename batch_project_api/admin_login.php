<?php
header('Content-Type: application/json; charset=utf-8');

$admin_email = "admin@gmail.com";
$admin_password = "Admin@12345"; 

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['code' => 400, 'message' => 'Email and password are required']);
    exit;
}

if ($email === $admin_email && $password === $admin_password) {
    echo json_encode([
        'code' => 200,
        'message' => 'Admin login successful',
        'admin' => [
            'email' => $admin_email,
            'role' => 'admin'
        ]
    ]);
} else {
    echo json_encode(['code' => 401, 'message' => 'Invalid admin credentials']);
}
?>