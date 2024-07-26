<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch resource to edit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE id = ?");
    $stmt->execute([$id]);
    $resource = $stmt->fetch();
}

// Handle edit form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $resource_type = $_POST['resource_type'];

    // Check the type of resource to handle the form submission accordingly
    if ($resource_type === 'Bound High Court Decision') {
        $index_number = $_POST['index_number']; // Only allow editing the index_number
        // Update only the index_number field
        $stmt = $pdo->prepare("UPDATE resources SET index_number = ? WHERE id = ?");
        $stmt->execute([$index_number, $id]);
    } else if ($resource_type === 'Case Book') {
        // Allow all fields to be editable
        $index_number = $_POST['index_number'];
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

        // Update all fields for Case Books
        $stmt = $pdo->prepare("UPDATE resources SET index_number = ?, accession_no = ?, title = ?, author = ?, edition = ?, volume = ?, publisher = ?, year_of_publication = ?, isbn = ?, class = ?, station = ? WHERE id = ?");
        $stmt->execute([$index_number, $accession_no, $title, $author, $edition, $volume, $publisher, $year_of_publication, $isbn, $class, $station, $id]);
    }

    header("Location: view_resources.php"); // Redirect to view resources
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
    <title>Edit Resource</title>
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
        .container {
            width: 100%;
            max-width: 900px;
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
</div>

<div class="content-wrapper">
    <div class="container">
        <h2 class="mt-5">Edit Resource</h2>

        <form method="post" class="mt-3">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($resource['id'] ?? ''); ?>">
            <input type="hidden" name="resource_type" value="<?php echo htmlspecialchars($resource['resource_type'] ?? ''); ?>">

            <?php if ($resource['resource_type'] === 'Bound High Court Decision'): ?>
                <div class="form-group">
                    <label for="index_number">Index Number:</label>
                    <input type="text" class="form-control" id="index_number" name="index_number" value="<?php echo htmlspecialchars($resource['index_number'] ?? ''); ?>" required>
                </div>
            <?php elseif ($resource['resource_type'] === 'Case Book'): ?>
                
                <div class="form-group">
                    <label for="accession_no">Accession No:</label>
                    <input type="text" class="form-control" id="accession_no" name="accession_no" value="<?php echo htmlspecialchars($resource['accession_no'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($resource['title'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($resource['author'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="edition">Edition:</label>
                    <input type="text" class="form-control" id="edition" name="edition" value="<?php echo htmlspecialchars($resource['edition'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="volume">Volume:</label>
                    <input type="text" class="form-control" id="volume" name="volume" value="<?php echo htmlspecialchars($resource['volume'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher:</label>
                    <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo htmlspecialchars($resource['publisher'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="year_of_publication">Year of Publication:</label>
                    <input type="number" class="form-control" id="year_of_publication" name="year_of_publication" value="<?php echo htmlspecialchars($resource['year_of_publication'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($resource['isbn'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="class">Class:</label>
                    <input type="text" class="form-control" id="class" name="class" value="<?php echo htmlspecialchars($resource['class'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="station">Station:</label>
                    <input type="text" class="form-control" id="station" name="station" value="<?php echo htmlspecialchars($resource['station'] ?? ''); ?>" required>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Update Resource</button>
        </form>

        <div class="mt-3">
            <a href="view_resources.php" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

<div class="navbar-bottom">
    <p>&copy; 2024 Meru Law Court Library Management System |
    <div class="social-icons">
        Contact us: 
        <a href="mailto:info@librarysystem.com"><img src="icons/email.png" alt="Email" height="20"></a>
        <a href="https://www.facebook.com/librarysystem"><img src="icons/facebook.png" alt="Facebook" height="20"></a>
        <a href="https://www.instagram.com/librarysystem"><img src="icons/instagram.png" alt="Instagram" height="20"></a>
        <a href="https://wa.me/123456789"><img src="icons/whatsapp.png" alt="WhatsApp" height="20"></a>
        <a href="https://twitter.com/librarysystem"><img src="icons/twitter.png" alt="Twitter" height="20"></a>
    </div>
    </p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
