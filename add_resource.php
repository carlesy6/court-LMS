<?php
session_start();
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'librarian') {
    header("Location: login.php");
    exit(); // Ensure no further code is executed after redirection
}

include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resource_type = $_POST['resource_type'];

    // Default all fields to null
    $resource_number = null;
    $index_number = null;
    $accession_no = null;
    $title = null;
    $author = null;
    $edition = null;
    $volume = null;
    $publisher = null;
    $year_of_publication = null;
    $isbn = null;
    $class = null;
    $station = null;

    if ($resource_type == 'Case Book') {
        // Capture fields only for Case Book
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

        try {
            // Check if the accession_no already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM resources WHERE accession_no = ?");
            $stmt->execute([$accession_no]);
            $exists = $stmt->fetchColumn();

            if ($exists) {
                $message = "<div class='alert alert-danger'>Error: Accession number already exists.</div>";
            } else {
                // Insert new Case Book resource
                $stmt = $pdo->prepare("INSERT INTO resources (resource_type, accession_no, title, author, edition, volume, publisher, year_of_publication, isbn, class, station) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$resource_type, $accession_no, $title, $author, $edition, $volume, $publisher, $year_of_publication, $isbn, $class, $station]);
                $message = "<div class='alert alert-success'>Case Book added successfully!</div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } elseif ($resource_type == 'Bound High Court Decision') {
        // Capture fields only for Bound High Court Decision
        
        $index_number = $_POST['index_number'];

        try {
            // Check if the resource_number already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM resources WHERE resource_number = ?");
            $stmt->execute([$resource_number]);
            $exists = $stmt->fetchColumn();

            if ($exists) {
                $message = "<div class='alert alert-danger'>Error: Resource number already exists.</div>";
            } else {
                // Insert new Bound High Court Decision resource
                $stmt = $pdo->prepare("INSERT INTO resources (resource_type, resource_number, index_number) VALUES (?, ?, ?)");
                $stmt->execute([$resource_type, $resource_number, $index_number]);
                $message = "<div class='alert alert-success'>Bound High Court Decision added successfully!</div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
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
    <style>
        .navbar-top, .navbar-bottom {
            background-color: #000;
            color: #fff;
            padding: 10px;
        }
        .navbar-top a, .navbar-bottom a {
            color: #fff;
            margin-right: 15px;
        }
        .social-icons a {
            color: #fff;
        }
    </style>
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

        <!-- Form with dynamic fields based on resource type -->
        <form method="post" class="mt-3" id="resourceForm">
            <!-- Dropdown to select resource type -->
            <div class="form-group">
                <label for="resource_type">Select Resource Type:</label>
                <select class="form-control" id="resource_type" name="resource_type" onchange="showFields(this.value)" required>
                    <option value="">Select Type</option>
                    <option value="Case Book">Case Book</option>
                    <option value="Bound High Court Decision">Bound High Court Decision</option>
                </select>
            </div>

            <!-- Conditional fields based on resource type -->
            <div id="caseBookFields" style="display: none;">
                <div class="form-group">
                    <label for="accession_no">Accession No:</label>
                    <input type="text" class="form-control" id="accession_no" name="accession_no">
                </div>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" class="form-control" id="author" name="author">
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
                    <label for="class">Class Number:</label>
                    <input type="text" class="form-control" id="class" name="class">
                </div>
                <div class="form-group">
                    <label for="station">Station:</label>
                    <input type="text" class="form-control" id="station" name="station">
                </div>
            </div>

            <div id="boundHighCourtFields" style="display: none;">
                
                <div class="form-group">
                    <label for="index_number">Index Number:</label>
                    <input type="text" class="form-control" id="index_number" name="index_number">
                </div>
            </div>

            <!-- Submit button for both resource types -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Home</a>
            <a href="librarian_dashboard.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    <div class="navbar-bottom">
        <p>&copy; 2024 Court Library Management System. All rights reserved.</p>
        <div class="social-icons">
            Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a> |
            <a href="mailto:catemuthoni19@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
            <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to show fields based on selected resource type
        function showFields(resourceType) {
            document.getElementById('caseBookFields').style.display = resourceType === 'Case Book' ? 'block' : 'none';
            document.getElementById('boundHighCourtFields').style.display = resourceType === 'Bound High Court Decision' ? 'block' : 'none';
        }
    </script>
</body>
</html>