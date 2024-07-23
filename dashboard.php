<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard</title>
</head>
<body>
<div class="content-wrapper">
    <div class="container">
        <h2 class="mt-5">Dashboard</h2>
        <div class="list-group mt-3">
            <a href="add_resource.php" class="list-group-item list-group-item-action">Add Resource</a>
            <a href="view_resources.php" class="list-group-item list-group-item-action">View Resources</a>
            <a href="borrow_resource.php" class="list-group-item list-group-item-action">Borrow Resource</a>
            <a href="return_resource.php" class="list-group-item list-group-item-action">Return Resource</a>
        </div>
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Home</a>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>
</div>

<div class="navbar-bottom">
    <p>&copy; 2024 Meru Law Court Library Management System | <a href="mailto:youremail@example.com">Email</a> | 
    <a href="https://facebook.com/yourprofile">Facebook</a> | 
    <a href="https://instagram.com/yourprofile">Instagram</a> | 
    <a href="https://wa.me/yourphonenumber">WhatsApp</a> | 
    <a href="https://twitter.com/yourprofile">Twitter</a></p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>