<?php
session_start();
if (!isset($_SESSION['user_id'])) {
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
</head>
<body>
<div class="content-wrapper">
    <div class="container">
        <h2 class="mt-5">View Resources</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Resource Number</th>
                    <th>Resource Type</th>
                    <th>Accession No</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Edition</th>
                    <th>Volume</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>ISBN</th>
                    <th>Class</th>
                    <th>Station</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resources as $index => $resource): ?>
                <tr>
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
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Home</a>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
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
