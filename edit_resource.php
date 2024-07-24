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
    $resource_type = $_POST['resource_type'];
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
    $id = intval($_POST['id']);

    $stmt = $pdo->prepare("UPDATE resources SET resource_type = ?, accession_no = ?, title = ?, author = ?, edition = ?, volume = ?, publisher = ?, year_of_publication = ?, isbn = ?, class = ?, station = ? WHERE id = ?");
    $stmt->execute([$resource_type, $accession_no, $title, $author, $edition, $volume, $publisher, $year_of_publication, $isbn, $class, $station, $id]);

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
</head>
<body>
<div class="container">
    <h2 class="mt-5">Edit Resource</h2>

    <form method="post" class="mt-3">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($resource['id'] ?? ''); ?>">
        <div class="form-group">
            <label for="resource_type">Resource Type:</label>
            <select class="form-control" id="resource_type" name="resource_type" required>
                <option value="Case Book" <?php echo ($resource['resource_type'] ?? '') == 'Case Book' ? 'selected' : ''; ?>>Case Book</option>
                <option value="Case File" <?php echo ($resource['resource_type'] ?? '') == 'Case File' ? 'selected' : ''; ?>>Case File</option>
            </select>
        </div>
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
            <input type="text" class="form-control" id="edition" name="edition" value="<?php echo htmlspecialchars($resource['edition'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="volume">Volume:</label>
            <input type="text" class="form-control" id="volume" name="volume" value="<?php echo htmlspecialchars($resource['volume'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="publisher">Publisher:</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo htmlspecialchars($resource['publisher'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="year_of_publication">Year of Publication:</label>
            <input type="number" class="form-control" id="year_of_publication" name="year_of_publication" value="<?php echo htmlspecialchars($resource['year_of_publication'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="isbn">ISBN:</label>
            <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($resource['isbn'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="class">Class:</label>
            <input type="text" class="form-control" id="class" name="class" value="<?php echo htmlspecialchars($resource['class'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="station">Station:</label>
            <input type="text" class="form-control" id="station" name="station" value="<?php echo htmlspecialchars($resource['station'] ?? ''); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Resource</button>
    </form>

    <div class="mt-3">
        <a href="view_resources.php" class="btn btn-secondary">Back</a>
    </div>
</div>
</body>
</html>
