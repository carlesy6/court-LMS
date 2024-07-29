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
    
    // Prepare and execute the deletion query
    $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
    $stmt->execute([$delete_id]);

    // Redirect to avoid re-submission and to refresh the list
    header("Location: case_books.php"); 
    exit();
}

// Fetch resources of type Case Book
$stmt = $pdo->prepare("SELECT * FROM resources WHERE resource_type = 'Case Book' ORDER BY id");
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
    <title>View Case Books</title>
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
            background-color: #343a40; /* Dark background for table */
            color: #ffffff; /* White text color */
        }
        th, td {
            padding: 4px 6px; /* Reduced padding for smaller cells */
            text-align: left;
            border: 1px solid #495057; /* Darker border color for contrast */
            vertical-align: middle; /* Center text vertically */
            height: 30px; /* Set specific height for rows */
            overflow: scroll; /* Hide overflow text */
            text-overflow: clip; /* Add ellipsis to overflowing text */
            white-space: nowrap; /* Prevent text wrapping */
        }
        th {
            background-color: #495057; /* Darker background for headers */
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
        /* Search bar styles */
        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            margin-top: 20px; /* Space for the search bar */
        }
        .search-bar input[type="text"] {
            width: 60%;
            max-width: 400px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
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

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search for resources..." onkeyup="filterResources()">
        </div>

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
                <tbody id="resourceTableBody">
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

<script>
    // JavaScript for filtering resources
    function filterResources() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const tableBody = document.getElementById('resourceTableBody');
        const resourceRows = tableBody.getElementsByClassName('resource-row');

        for (let i = 0; i < resourceRows.length; i++) {
            const row = resourceRows[i];
            const cells = row.getElementsByTagName('td');
            let matchFound = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                const cellText = cell.textContent || cell.innerText;

                if (cellText.toLowerCase().includes(searchInput)) {
                    matchFound = true;
                    break;
                }
            }

            if (matchFound) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
</script>
</body>
</html>
