<?php
include "connect.php";
header('Content-Type: application/json; charset=utf-8');

$id = $_GET['id'] ?? '';

$cols = "id, client_name, title, description, type, status, members_names, start_date, end_date";

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
} else {
    $result = $con->query("SELECT $cols FROM batch_project");
    $projects = [];
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    echo json_encode($projects);
}
?>