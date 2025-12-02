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
$reason_for_hold = $_POST['reason_for_hold'] ?? '';
$admin_notes = $_POST['admin_notes'] ?? '';
$stage = 0;

if ($client_name && $title && $description && $type && $start_date && $end_date) {

    $stmt = $con->prepare("
        INSERT INTO batch_project 
        (client_name, title, description, type, status, members_names, start_date, end_date, reason_for_hold, admin_notes, stage)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)    
    ");

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed"]);
        exit;
    }

    $stmt->bind_param(
        "ssssssssssi",
        $client_name,
        $title,
        $description,
        $type,
        $status,
        $members_names,
        $start_date,
        $end_date,
        $reason_for_hold,
        $admin_notes,
        $stage
    );

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Project inserted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Insert failed"]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
}
?>