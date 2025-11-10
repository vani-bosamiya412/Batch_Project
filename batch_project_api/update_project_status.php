<?php
include "connect.php";

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';

if ($id && $status) {
    $stmt = $con->prepare("UPDATE batch_project SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Project status updated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Status update failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Project ID and status required"]);
}
?>