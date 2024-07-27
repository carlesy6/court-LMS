<?php
include 'db.php';

// Prepare and execute the SQL statement to fetch borrowed resources
$stmt = $pdo->prepare("SELECT r.accession_no, r.title, r.author, r.isbn, t.borrowed_on, c.name AS client_name, c.id_no, c.phone 
                       FROM transactions t 
                       JOIN resources r ON t.resource_id = r.id 
                       JOIN clients c ON t.user_id = c.id 
                       WHERE t.action = 'borrowed' 
                       ORDER BY t.borrowed_on DESC");
$stmt->execute();
$borrowedResources = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Linking Google Fonts for modern condensed serif font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Borrowed Resources</title>
    <style>
        /* Apply the modern condensed serif font to the entire document */
        body, h2, .table, .btn, .navbar-bottom, .navbar-bottom p, .social-icons {
            font-family: 'Roboto Condensed', serif;
        }
        
        .search-bar {
            max-width: 400px;
            margin-bottom: 20px;
        }
        
        .download-btn {
            margin-bottom: 20px;
        }

        .action-buttons {
            margin-top: 10px;
            margin-bottom: 20px;
        }
        
        .table th, .table td {
            color: white !important;  /* Set text color to white */
            background-color: #333;   /* Set a dark background for better contrast */
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #444;  /* Alternate row colors */
        }
        
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #555;
        }
        
        .navbar-bottom {
            background-color: #222;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        
        .navbar-bottom a {
            color: #a8d5e2;
            text-decoration: none;
        }

        .social-icons i {
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-5">Borrowed Resources</h2>

    <!-- Home and Back Buttons -->
    <div class="action-buttons">
        <button class="btn btn-primary" onclick="goHome()">Home</button>
        <button class="btn btn-secondary" onclick="goBack()">Back</button>
    </div>

    <!-- Search Bar -->
    <div class="input-group mb-3 search-bar">
        <input type="text" id="searchInput" class="form-control" placeholder="Search for resources...">
        <div class="input-group-append">
            <button class="btn btn-primary" type="button" onclick="searchTable()">Search</button>
        </div>
    </div>

    <!-- Download Button -->
    <button class="btn btn-success download-btn" onclick="downloadCSV()">Download CSV</button>

    <table class="table table-striped mt-3" id="resourcesTable">
        <thead>
            <tr>
                <th>#</th> <!-- New column for numbering -->
                <th>Accession No</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Borrowed On</th>
                <th>Client Name</th>
                <th>Client ID</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1; // Initialize a counter variable for numbering
            foreach ($borrowedResources as $resource): ?>
                <tr>
                    <td><?php echo $count++; ?></td> <!-- Display the counter and increment it -->
                    <td><?php echo htmlspecialchars($resource['accession_no']); ?></td>
                    <td><?php echo htmlspecialchars($resource['title']); ?></td>
                    <td><?php echo htmlspecialchars($resource['author']); ?></td>
                    <td><?php echo htmlspecialchars($resource['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($resource['borrowed_on']); ?></td>
                    <td><?php echo htmlspecialchars($resource['client_name']); ?></td>
                    <td><?php echo htmlspecialchars($resource['id_no']); ?></td>
                    <td><?php echo htmlspecialchars($resource['phone']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="navbar-bottom">
    <p>&copy; 2024 Meru Law Court Library Management System |
        <div class="social-icons">
        Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a> |
            <a href="mailto:catemuthoni19@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
            <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a> |
        </div>
    </p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Function to filter table based on search input
    function searchTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('resourcesTable');
        const trs = table.getElementsByTagName('tr');

        for (let i = 1; i < trs.length; i++) {
            const tds = trs[i].getElementsByTagName('td');
            let isVisible = false;

            for (let j = 0; j < tds.length; j++) {
                if (tds[j].textContent.toLowerCase().includes(input)) {
                    isVisible = true;
                    break;
                }
            }

            trs[i].style.display = isVisible ? '' : 'none';
        }
    }

    // Function to download table data as CSV
    function downloadCSV() {
        const table = document.getElementById('resourcesTable');
        let csvContent = 'data:text/csv;charset=utf-8,';
        const rows = table.querySelectorAll('tr');

        rows.forEach(row => {
            const cols = row.querySelectorAll('td, th');
            const csvRow = [];

            cols.forEach(col => csvRow.push(col.innerText));
            csvContent += csvRow.join(',') + '\r\n';
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'borrowed_resources.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Function to navigate to the Home page
    function goHome() {
        window.location.href = 'index.php'; // Change 'index.php' to your home page URL
    }

    // Function to go back to the previous page
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
