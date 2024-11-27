<?php
session_start();
include('database.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $flipbookId = intval($_GET['id']);
    $userId = $_SESSION['user_id'];

    // Check if the flipbook belongs to the user
    $sql = "SELECT flipbook_path FROM flipbooks WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $flipbookId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $flipbook = $result->fetch_assoc();

    if ($flipbook) {
        // Delete the flipbook file from the server
        if (file_exists($flipbook['flipbook_path'])) {
            unlink($flipbook['flipbook_path']);
        }

        // Delete the flipbook record from the database
        $deleteSql = "DELETE FROM flipbooks WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $flipbookId);
        $deleteStmt->execute();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Flipbook not found or not authorized']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
