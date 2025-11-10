<?php
include "connect.php";

$id = $_POST['id'] ?? '';
$client_name = $_POST['client_name'] ?? '';
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$type = $_POST['type'] ?? '';
$status = $_POST['status'] ?? '';
$members_names = $_POST['members_names'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';

if ($id) {
    $stmt = $con->prepare("UPDATE batch_project 
                           SET client_name=?, title=?, description=?, type=?, status=?, members_names=?, start_date=?, end_date=? 
                           WHERE id=?");
    $stmt->bind_param("ssssssssi", $client_name, $title, $description, $type, $status, $members_names, $start_date, $end_date, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Project updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Project ID required"]);
}
?>