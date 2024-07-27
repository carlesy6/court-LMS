<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_name = $_POST['client_name'];
    $client_id_no = $_POST['client_id_no'];
    $client_phone = $_POST['client_phone'];
    $resource_accession_no = $_POST['resource_accession_no'];
    $resource_title = $_POST['resource_title'];
    $resource_author = $_POST['resource_author'];
    $resource_isbn = $_POST['resource_isbn'];
    $id = $_SESSION['id'];

    $pdo->beginTransaction();
    
    // Search for the resource with provided details
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE 
        (accession_no = ? OR ? = '') AND
        (title LIKE ? OR ? = '') AND
        (author LIKE ? OR ? = '') AND
        (isbn = ? OR ? = '') AND
        status = 'borrowed'");
    $stmt->execute([$resource_accession_no, $resource_accession_no, "%$resource_title%", $resource_title, "%$resource_author%", $resource_author, $resource_isbn, $resource_isbn]);
    $resource = $stmt->fetch();

    if ($resource) {
        $resource_id = $resource['id'];

        // Update the resource status to 'available'
        $stmt = $pdo->prepare("UPDATE resources SET status = 'available' WHERE id = ? AND status = 'borrowed'");
        $stmt->execute([$resource_id]);

        if ($stmt->rowCount() > 0) {
            // Record the return transaction without specifying the primary key
            $stmt = $pdo->prepare("INSERT INTO transactions (resource_id, action) VALUES (?, 'returned')");
            $stmt->execute([$resource_id]);

            // Update client details in clients table
            $stmt = $pdo->prepare("INSERT INTO clients (id, name, id_no, phone) VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE name = VALUES(name), id_no = VALUES(id_no), phone = VALUES(phone)");
            $stmt->execute([$id, $client_name, $client_id_no, $client_phone]);

            $pdo->commit();
            echo "<div class='alert alert-success'>Resource returned successfully!</div>";
        } else {
            $pdo->rollBack();
            echo "<div class='alert alert-danger'>Resource was not borrowed or already returned!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>No matching resource found!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Return Resource</title>
</head>
<body>
<div class="content-wrapper">
    <div class="container">
        <h2 class="mt-5">Return Resource</h2>
        <form method="post" class="mt-3">
            <div class="form-group">
                <label for="client_name">Client Name:</label>
                <input type="text" class="form-control" id="client_name" name="client_name" required>
            </div>
            <div class="form-group">
                <label for="client_id_no">Client ID Number:</label>
                <input type="text" class="form-control" id="client_id_no" name="client_id_no" required>
            </div>
            <div class="form-group">
                <label for="client_phone">Client Phone Number:</label>
                <input type="text" class="form-control" id="client_phone" name="client_phone" required>
            </div>
            <div class="form-group">
                <label for="resource_accession_no">Resource Accession Number:</label>
                <input type="text" class="form-control" id="resource_accession_no" name="resource_accession_no">
            </div>
            <div class="form-group">
                <label for="resource_title">Resource Title:</label>
                <input type="text" class="form-control" id="resource_title" name="resource_title">
            </div>
            <div class="form-group">
                <label for="resource_author">Resource Author:</label>
                <input type="text" class="form-control" id="resource_author" name="resource_author">
            </div>
            <div class="form-group">
                <label for="resource_isbn">Resource ISBN:</label>
                <input type="text" class="form-control" id="resource_isbn" name="resource_isbn">
            </div>
            <button type="submit" class="btn btn-primary">Return Resource</button>
        </form>
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Home</a>
            <a href="librarian_dashboard.php" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

<div class="navbar-bottom">
    <>&copy; 2024 Meru Law Court Library Management System | 
        <div class="social-icons">
        Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a> |
            <a href="mailto:catemuthoni19@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
            <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a> |
           
           
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
