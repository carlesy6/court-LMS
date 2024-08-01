<?php
session_start();

// Correct session check
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'librarian' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: view_resources.php"); // Redirect to avoid re-submission
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>View Resources</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 120px); /* Adjust for navbar height + footer height */
            width: 100vw;
            overflow: hidden;
            margin-top: 60px; /* Adjust for top navbar height */
        }
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .btn-custom {
            margin: 0 15px;
            padding: 10px 20px;
            font-size: 1.2rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .navbar-bottom {
            background-color: black;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 1000;
        }
        .navbar-bottom a {
            margin: 0 5px;
            color: white;
            text-decoration: none;
        }
        .navbar-top {
            background-color: black;
            padding: 10px;
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }
        .navbar-top .btn {
            color: white;
            background-color: transparent;
            border: none;
            text-decoration: none;
        }
        .navbar-top .btn:hover {
            color: #ddd;
        }
        .social-icons a {
            color: #a8d5e2;
            text-decoration: none;
        }
        .social-icons i {
            margin-right: 5px;
            color: #a8d5e2;
        }
    </style>
</head>
<body>
<div class="navbar-top">
    <div>
        <a href="index.php" class="btn btn-secondary">Home</a>
        <a href="librarian_dashboard.php" class="btn btn-secondary">Back</a>
    </div>
    <div>
        <a href="download.php" class="btn btn-primary">Download CSV</a>
    </div>
</div>

<div class="content-wrapper">
    <div class="button-container">
        <button onclick="location.href='case_books.php'" class="btn-custom">View Case Books</button>
        <button onclick="location.href='Bound_High_Court_Decision.php'" class="btn-custom">View Bound High Court Decision</button>
    </div>
</div>

<div class="navbar-bottom">
    <p>&copy; 2024 Meru Law Court Library Management System |</p>
    <div class="social-icons">
        Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a> |
        <a href="mailto:catemuthoni19@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
        <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome for icons -->
</body>
</html>
