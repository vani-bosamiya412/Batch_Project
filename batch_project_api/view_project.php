<?php
include "connect.php";
header('Content-Type: application/json; charset=utf-8');

$id = $_GET['id'] ?? '';
$status = $_GET['status'] ?? '';

$cols = "id, client_name, title, description, type, status, approved_by_admin, reason_for_hold, admin_notes, members_names, start_date, end_date, completion_requested_by";

if ($id > 0) {
    $stmt = $con->prepare("SELECT $cols FROM batch_project WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();

    if ($project) {
        echo json_encode($project);
    } else {
        echo json_encode(["status" => "error", "message" => "Project not found"]);
    }
    exit;
}

if (!empty($status)) {
    $stmt = $con->prepare("SELECT $cols FROM batch_project WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $con->query("SELECT $cols FROM batch_project");
}

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

if (!empty($status)) {
    $count_stmt = $con->prepare("SELECT COUNT(*) AS total FROM batch_project WHERE status = ?");
    $count_stmt->bind_param("s", $status);
} else {
    $count_stmt = $con->prepare("SELECT COUNT(*) AS total FROM batch_project");
}
$count_stmt->execute();
$count_result = $count_stmt->get_result()->fetch_assoc();

echo json_encode([
    "status" => "success",
    "total_projects" => $count_result['total'],
    "filter" => $status ?: "all",
    "projects" => $projects
]);
?>