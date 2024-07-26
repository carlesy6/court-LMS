<?php
session_start();

// Check if the user is an admin; redirect to login if not
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Check if the ID is provided and valid
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare and execute deletion statement
    try {
        $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
        $stmt->execute([$id]);

        // Check if a row was actually deleted
        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = "Resource successfully deleted.";
        } else {
            $_SESSION['message'] = "Resource not found or already deleted.";
        }
    } catch (PDOException $e) {
        // Log the error or handle it accordingly
        $_SESSION['message'] = "Error deleting resource: " . $e->getMessage();
    }
} else {
    $_SESSION['message'] = "Invalid resource ID.";
}

// Redirect to the resources view page with a status message
header("Location: view_resources.php");
exit();
?>
