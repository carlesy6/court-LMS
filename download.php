<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch resources
$stmt = $pdo->query("SELECT * FROM resources ORDER BY id");
$resources = $stmt->fetchAll();

// Set headers to force download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="resources.csv"');

// Output CSV data
$output = fopen('php://output', 'w');

// Output column headers
fputcsv($output, [
    'Resource Number', 'Resource Type', 'Accession No', 'Title', 'Author',
    'Edition', 'Volume', 'Publisher', 'Year', 'ISBN', 'Class', 'Station', 'Status'
]);

// Output data rows
foreach ($resources as $index => $resource) {
    fputcsv($output, [
        $index + 1, // Resource Number
        $resource['resource_type'],
        $resource['accession_no'],
        $resource['title'],
        $resource['author'],
        $resource['edition'],
        $resource['volume'],
        $resource['publisher'],
        $resource['year_of_publication'],
        $resource['isbn'],
        $resource['class'],
        $resource['station'],
        $resource['status']
    ]);
}

fclose($output);
exit;
?>