<?php
include "connect.php";

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';
$reason_for_hold = $_POST['reason_for_hold'] ?? '';
$role = $_POST['role'] ?? ''; 

if (!$id || !$status) {
    echo json_encode(["status" => "error", "message" => "Project ID and status required"]);
    exit;
}

if ($status === "On Hold" && empty($reason_for_hold)) {
    echo json_encode(["status" => "error", "message" => "Reason for hold is required"]);
    exit;
}

$stageUpdate = "";
if ($status === "Completed") {
    switch ($role) {
        case "Designer": 
            $stageUpdate = ", stage=1"; 
            break;
        case "App Developer":
        case "Web Developer":
            $stageUpdate = ", stage=2"; 
            break;
        case "Backend":
            $stageUpdate = ", stage=3"; 
            break;
        case "Tester":
            $stageUpdate = ", stage=4"; 
            break;
    }
}

if ($role === "Tester" && $status === "Completed") {

    $stmt = $con->prepare("
        UPDATE batch_project 
        SET status='Completed', approved_by_admin='Pending' $stageUpdate
        WHERE id=?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode([
        "status" => "success", 
        "message" => "Completion request sent. Waiting for admin approval."
    ]);
    exit;
}

if ($status !== "On Hold") {
    $reason_for_hold = "";
}

$stmt = $con->prepare("
    UPDATE batch_project 
    SET status=?, reason_for_hold=? $stageUpdate
    WHERE id=?
");

$stmt->bind_param("ssi", $status, $reason_for_hold, $id);
$stmt->execute();

echo json_encode(["status" => "success", "message" => "Project status updated"]);
?>