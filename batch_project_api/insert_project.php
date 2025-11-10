<?php
include "connect.php";

$client_name = $_POST['client_name'] ?? '';
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$type = $_POST['type'] ?? '';
$status = $_POST['status'] ?? 'Pending';
$members_names = $_POST['members_names'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';

if ($client_name && $title && $description && $type && $start_date && $end_date) {
    $stmt = $con->prepare("INSERT INTO batch_project (client_name, title, description, type, status, members_names, start_date, end_date)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $client_name, $title, $description, $type, $status, $members_names, $start_date, $end_date);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Project inserted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Insert failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
}
?>