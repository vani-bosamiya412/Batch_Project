<?php
include "connect.php";

$id = $_POST['id'] ?? '';
$action = $_POST['approved_by_admin'] ?? ''; 

if (!$id || !$action) {
    echo json_encode(["status" => "error", "message" => "ID and action required"]);
    exit;
}

if ($action === "Approved") {
    $stmt = $con->prepare("
        UPDATE batch_project 
        SET approved_by_admin='Approved'
        WHERE id=?
    ");
}

if ($action === "Rejected") {
    $stmt = $con->prepare("
        UPDATE batch_project 
        SET approved_by_admin='Rejected', status='Continue'
        WHERE id=?
    ");
}

$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(["status" => "success", "message" => "Action applied"]);
?>