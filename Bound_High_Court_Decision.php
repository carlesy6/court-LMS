<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to home or another appropriate page
    exit();
}

include 'db.php';

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    try {
        $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
        $stmt->execute([$delete_id]);

        // Check if a row was actually deleted
        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = "Resource successfully deleted.";
        } else {
            $_SESSION['message'] = "Resource not found or already deleted.";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error deleting resource: " . $e->getMessage();
    }
    header("Location: Bound_High_Court_Decision.php");

    exit();
}

// Fetch resources of type Bound High Court Decision
$stmt = $pdo->prepare("SELECT * FROM resources WHERE resource_type = 'Bound High Court Decision' ORDER BY id");
$stmt->execute();
$resources = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>View Bound High Court Decision</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-size: 14px; /* Slightly smaller base font size */
        }
        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 120px); /* Adjust for navbar height + footer height */
            width: 100vw;
            overflow: scroll;
            margin-top: 60px; /* Adjust for top navbar height */
        }
        .table-container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .table-responsive {
            flex: 1; /* Allows the table to take up remaining space */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem; /* Smaller font size */
            table-layout: fixed; /* Force fixed-width cells */
        }
        th, td {
            padding: 4px 6px; /* Reduced padding for smaller cells */
            text-align: left;
            border: 1px solid #dee2e6; /* Add border for clarity */
            vertical-align: middle; /* Center text vertically */
            height: 30px; /* Set specific height for rows */
            overflow: hidden; /* Hide overflow text */
            text-overflow: ellipsis; /* Add ellipsis to overflowing text */
            white-space: nowrap; /* Prevent text wrapping */
        }
        th {
            background-color: black;
            color: white;
            font-weight: bold;
            height: 35px; /* Specific height for header rows */
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
        }
        .navbar-top .btn:hover {
            color: #ddd;
        }
        .sticky-header {
            background-color: black;
            color: white;
            text-align: left;
            font-weight: bold;
            position: sticky; /* Stick to the top */
            top: 0; /* Align to the top */
            z-index: 100; /* Ensure it stays on top of other elements */
        }
        .btn-sm {
            font-size: 0.8rem; /* Smaller button text */
            padding: 2px 5px; /* Reduced button padding */
        }
    </style>
</head>
<body>
<div class="navbar-top">
    <div>
        <a href="index.php" class="btn btn-secondary">Home</a>
        <a href="view_resources.php" class="btn btn-secondary">Back</a>
    </div>
    <div>
        <a href="download.php" class="btn btn-primary">Download CSV</a>
    </div>
</div>

<div class="content-wrapper">
    <div class="table-container">
        <div class="table-responsive">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-info">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="sticky-header">Resource Number</th>
                        <th class="sticky-header">Index Number</th>
                        <th class="sticky-header">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resources as $index => $resource): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td> <!-- Sequential numbering starts from 1 -->
                        <td><?php echo htmlspecialchars($resource['index_number']); ?></td>
                        <td>
                            <a href="edit_resource.php?id=<?php echo $resource['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete_id=<?php echo $resource['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this resource?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="navbar-bottom">
    <p>&copy; 2024 Meru Law Court Library Management System | 
    <div class="social-icons">
        Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a> |
        <a href="mailto:catemuthoni19@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
        <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
