<?php
session_start();
include('database.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT id, flipbook_name AS name, flipbook_path AS path, created_at FROM flipbooks WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$flipbooks = [];
while ($row = $result->fetch_assoc()) {
    $flipbooks[] = $row;
}

echo json_encode($flipbooks);
?>
