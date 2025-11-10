<?php
include "connect.php";
header('Content-Type: application/json; charset=utf-8');

$id = $_GET['id'] ?? '';
$cols = "id, name, role, email, phone_number";

if ($id > 0) {
    $stmt = $con->prepare("SELECT $cols FROM batch_users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
} else {
    $result = $con->query("SELECT $cols FROM batch_users");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
}
?>