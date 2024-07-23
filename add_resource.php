<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit(); // Ensure no further code is executed after redirection
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resource_type = $_POST['resource_type'];
    $resource_number = $_POST['resource_number']; // New field for resource numbering
    $accession_no = $_POST['accession_no'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $edition = $_POST['edition'];
    $volume = $_POST['volume'];
    $publisher = $_POST['publisher'];
    $year_of_publication = $_POST['year_of_publication'];
    $isbn = $_POST['isbn'];
    $class = $_POST['class'];
    $station = $_POST['station'];

    $stmt = $pdo->prepare("INSERT INTO resources (resource_type, resource_number, accession_no, title, author, edition, volume, publisher, year_of_publication, isbn, class, station) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$resource_type, $resource_number, $accession_no, $title, $author, $edition, $volume, $publisher, $year_of_publication, $isbn, $class, $station]);

    $message = "<div class='alert alert-success'>Resource added successfully!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to custom CSS -->
    <title>Add Resource</title>
</head>
<body>
    <!-- Top Navigation Bar -->
    <div class="navbar-top">
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="view_resources.php">View Resources</a>
        <!-- Removed Add Resource link -->
    </div>

    <div class="container">
        <h2 class="mt-5">Add Resource</h2>

        <?php if (isset($message)) echo $message; ?>

        <form method="post" class="mt-3">
            <div class="form-group">
                <label for="resource_type">Resource Type:</label>
                <select class="form-control" id="resource_type" name="resource_type" required>
                    <option value="Case Book">Case Book</option>
                    <option value="Case File">Case File</option>
                </select>
            </div>
            <div class="form-group">
                <label for="resource_number">Resource Number:</label>
                <input type="text" class="form-control" id="resource_number" name="resource_number" required>
            </div>
            <div class="form-group">
                <label for="accession_no">Accession No:</label>
                <input type="text" class="form-control" id="accession_no" name="accession_no" required>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="edition">Edition:</label>
                <input type="text" class="form-control" id="edition" name="edition">
            </div>
            <div class="form-group">
                <label for="volume">Volume:</label>
                <input type="text" class="form-control" id="volume" name="volume">
            </div>
            <div class="form-group">
                <label for="publisher">Publisher:</label>
                <input type="text" class="form-control" id="publisher" name="publisher">
            </div>
            <div class="form-group">
                <label for="year_of_publication">Year of Publication:</label>
                <input type="number" class="form-control" id="year_of_publication" name="year_of_publication">
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn">
            </div>
            <div class="form-group">
                <label for="class">Class:</label>
                <input type="text" class="form-control" id="class" name="class">
            </div>
            <div class="form-group">
                <label for="station">Station:</label>
                <input type="text" class="form-control" id="station" name="station">
            </div>
            <button type="submit" class="btn btn-primary">Add Resource</button>
        </form>

        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Home</a>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    <div class="navbar-bottom">
        <p>&copy; 2024 Court Library Management System. All rights reserved.</p>
        <div>
            <a href="https://facebook.com" target="_blank">Facebook</a> |
            <a href="https://twitter.com" target="_blank">Twitter</a> |
            <a href="https://instagram.com" target="_blank">Instagram</a>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
