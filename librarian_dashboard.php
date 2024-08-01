<?php
session_start();

// Correct session check
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'librarian' && $_SESSION['role'] !== 'admin')) {
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Librarian Dashboard</title>
    <style>
        /* Basic styling for the list container */
        .circular-list {
            text-align: center; /* Center items horizontally */
            margin-top: 20px; /* Add margin on top */
        }

        /* Basic styling for each list item */
        .circular-list-item {
            display: block; /* Display items as block elements */
            width: 200px; /* Fixed width for items */
            margin: 10px auto; /* Center items horizontally and add vertical margin */
            padding: 15px; /* Add padding inside items */
            background-color: #007bff; /* Background color */
            color: white; /* Text color */
            border-radius: 5px; /* Slightly rounded corners */
            text-align: center; /* Center text horizontally */
            text-decoration: none; /* Remove underline */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Light shadow */
            transition: background-color 0.3s ease; /* Smooth hover transition */
        }

        /* Hover effect */
        .circular-list-item:hover {
            background-color: #0056b3; /* Darker background on hover */
        }

        /* Footer styles */
        .navbar-bottom {
            background-color: #222; /* Dark footer */
            color: white; /* White text */
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
        }

        .navbar-bottom a {
            color: #a8d5e2; /* Light blue links */
            text-decoration: none;
        }

        .social-icons i {
            color: white;
            margin-right: 5px;
        }

        .btn-secondary {
            background-color: #6c757d; /* Secondary button color */
            border-color: #6c757d;
        }

        .content-wrapper {
            min-height: 100vh; /* Ensure full viewport height */
            padding-bottom: 60px; /* Space for fixed footer */
            box-sizing: border-box;
        }

        .social-icons a {
            color: white;
            text-decoration: none;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="container">
            <h2 class="mt-5 text-center">Librarian Dashboard</h2>

            <!-- Basic List -->
            <div class="circular-list mt-4">
                <a href="add_resource.php" class="circular-list-item">Add Resource</a>
                <a href="view_resources.php" class="circular-list-item">View Resources</a>
                <a href="borrow_resource.php" class="circular-list-item">Borrow Resource</a>
                <a href="return_resource.php" class="circular-list-item">Return Resource</a>
                <a href="borrowed_resources.php" class="circular-list-item">View Borrowed</a>
            </div>

            <!-- Home Button -->
            <div class="mt-4 text-center">
                <a href="index.php" class="btn btn-secondary">Home</a>
            </div>

            <!-- Logout Button -->
            <div class="mt-2 text-center">
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="navbar-bottom">
        <p>&copy; 2024 Meru Law Court Library Management System |
            <div class="social-icons">
                Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a> |
                <a href="mailto:catemuthoni19@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
                <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
        </p>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome for icons -->
</body>
</html>
