<?php
include "connect.php";

$id = $_POST['id'] ?? '';

if ($id) {
    $stmt = $con->prepare("DELETE FROM batch_project WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Project deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Delete failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Project ID required"]);
}
?>