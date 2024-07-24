<?php
session_start();
if (!isset($_SESSION['id'])) {
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

// Fetch resources
$stmt = $pdo->query("SELECT * FROM resources ORDER BY id");
$resources = $stmt->fetchAll();
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
            height: 100%;
            border-collapse: collapse;
            font-size: 1rem; /* Increase font size */
        }
        th, td {
            padding: 20px; /* Increase cell padding */
            text-align: left;
            border: 1px solid #dee2e6; /* Add border for clarity */
        }
        th {
            background-color: black;
            color: white;
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
    </style>
</head>
<body>
<div class="navbar-top">
    <div>
        <a href="index.php" class="btn btn-secondary">Home</a>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </div>
    <div>
        <a href="download.php" class="btn btn-primary">Download CSV</a>
    </div>
</div>

<div class="content-wrapper">
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="tr">
                        <th class="sticky-header">Resource Number</th>
                        <th class="sticky-header">Resource Type</th>
                        <th class="sticky-header">Accession No</th>
                        <th class="sticky-header">Title</th>
                        <th class="sticky-header">Author</th>
                        <th class="sticky-header">Edition</th>
                        <th class="sticky-header">Volume</th>
                        <th class="sticky-header">Publisher</th>
                        <th class="sticky-header">Year</th>
                        <th class="sticky-header">ISBN</th>
                        <th class="sticky-header">Class</th>
                        <th class="sticky-header">Station</th>
                        <th class="sticky-header">Status</th>
                        <th class="sticky-header">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resources as $index => $resource): ?>
                    <tr class="resource-row">
                        <td><?php echo $index + 1; ?></td> <!-- Display sequential number -->
                        <td><?php echo htmlspecialchars($resource['resource_type'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['accession_no'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['title'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['author'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['edition'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['volume'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['publisher'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['year_of_publication'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['isbn'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['class'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['station'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($resource['status'] ?? ''); ?></td>
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
