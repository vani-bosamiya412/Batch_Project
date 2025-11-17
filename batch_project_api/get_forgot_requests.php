<?php
include "connect.php";
header('Content-Type: application/json; charset=utf-8');

$query = "SELECT fr.id, fr.user_id, fr.email, fr.created_at, u.role 
          FROM forgot_requests fr 
          JOIN batch_users u ON fr.user_id = u.id
          WHERE fr.status = 'pending'";

$result = $con->query($query);
$requests = [];

while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

echo json_encode([
    'code' => 200,
    'requests' => $requests
]);
?>