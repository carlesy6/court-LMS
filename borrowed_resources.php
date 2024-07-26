<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Initialize borrowed_resources
$borrowed_resources = [];

try {
    // Fetch borrowed resources
    $stmt = $pdo->prepare("SELECT r.id, r.accession_no, r.title, r.author, r.isbn, t.action, t.borrowed_on AS timestamp, c.name AS client_name, c.id_no AS client_id_no, c.phone AS client_phone
        FROM resources r
        JOIN transactions t ON r.id = t.resource_id
        JOIN clients c ON t.client_id = c.id
        WHERE t.action = 'borrowed'");
    $stmt->execute();
    $borrowed_resources = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage()); // Log error to file
    echo "Error: " . $e->getMessage(); // Display error message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Borrowed Resources</title>
</head>
<body>
<div class="content-wrapper">
    <div class="container">
        <h2 class="mt-5">Borrowed Resources</h2>

        <?php if (count($borrowed_resources) > 0): ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Accession No</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Client Name</th>
                        <th>Client ID No</th>
                        <th>Client Phone</th>
                        <th>Borrowed On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowed_resources as $resource): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($resource['accession_no']); ?></td>
                            <td><?php echo htmlspecialchars($resource['title']); ?></td>
                            <td><?php echo htmlspecialchars($resource['author']); ?></td>
                            <td><?php echo htmlspecialchars($resource['isbn']); ?></td>
                            <td><?php echo htmlspecialchars($resource['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($resource['client_id_no']); ?></td>
                            <td><?php echo htmlspecialchars($resource['client_phone']); ?></td>
                            <td><?php echo htmlspecialchars($resource['timestamp']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No borrowed resources found.</div>
        <?php endif; ?>

        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Home</a>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

<div class="navbar-bottom">
    <p>&copy; 2024 Meru Law Court Library Management System |
        <div class="social-icons">
        Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a> |
            <a href="mailto:catemuthoni19@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
            <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a> |
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
