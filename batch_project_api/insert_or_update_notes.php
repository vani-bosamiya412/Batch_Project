<?php
include "connect.php";
header('Content-Type: application/json; charset=utf-8');

$project_id = $_POST['id'] ?? '';
$admin_notes = $_POST['admin_notes'] ?? '';

if (empty($project_id)) {
    echo json_encode(['code' => 400, 'message' => 'Project ID is required']);
    exit;
}

$stmt = $con->prepare("
    UPDATE batch_project 
    SET admin_notes = ?
    WHERE id = ?
");

if (!$stmt) {
    echo json_encode(['code' => 500, 'message' => 'Database prepare failed']);
    exit;
}

$stmt->bind_param("si", $admin_notes, $project_id);

if ($stmt->execute()) {
    echo json_encode([
        'code' => 200,
        'message' => 'Notes saved successfully',
        'project_id' => $project_id
    ]);
} else {
    echo json_encode(['code' => 500, 'message' => 'Failed to save notes']);
}
?>