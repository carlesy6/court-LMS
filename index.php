<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meru Law Court Library Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to custom CSS -->
    <style>
        /* Apply a background color and image to the whole page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light color for better readability */
            background-image: url('R.jfif'); /* Update with your image path */
            background-size: cover; /* Cover the entire page */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeating */
            background-attachment: fixed; /* Fixed background for a parallax effect */
            color: #37bd0a;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navigation bar styles */
        .navbar-top, .navbar-bottom {
            background-color: green; /* Dark blue background */
            padding: 10px; /* Padding around the navbar */
            text-align: center; /* Center text in navbar */
        }

        .navbar-top a, .navbar-bottom a {
            color: #fff; /* White text color */
            padding: 14px 20px; /* Padding for navbar links */
            text-decoration: none; /* Remove underline from links */
            display: inline-block; /* Ensure links are displayed inline */
        }

        .navbar-top a:hover, .navbar-bottom a:hover {
            background-color: #00376b; /* Darker blue on hover */
        }

        /* Headings styles */
        h1, h2, h3, h4, h5, h6 {
            color: green; /* Darker text color for headings */
        }

        /* Paragraphs and other text */
        p, li {
            color: #333; /* Standard text color for paragraphs and list items */
        }

        /* Links */
        a {
            color: #0066cc; /* Link color */
        }

        a:hover {
            color: #004080; /* Darker blue for links on hover */
        }

        /* Styling for forms */
        form {
            margin-bottom: 20px;
        }

        /* Styling for tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
            text-decoration: none;
        }

        th {
            background-color: #f2f2f2; /* Light grey background for table headers */
            color: #333; /* Text color for table headers */
        }

        td.resource-text {
            color: #ff3300; /* Text color for all resource columns */
        }

        /* Additional styles for alerts */
        .alert {
            margin-top: 20px;
        }

        /* Ensure container has some margin from the top and flex-grow for main content */
        .container {
            margin-top: 50px; /* Adjust as needed */
            flex-grow: 1;
        }

        /* Ensure footer is at the bottom */
        .navbar-bottom {
            margin-top: auto;
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
        <a href="add_resource.php">Add Resource</a>
    </div>

    <div class="container">
        <div class="text-center mt-5">
            <h1 class="display-4">Meru Law Court Library Management System</h1>
            <p class="lead">Welcome to Meru Law Court.</p> <p class="lead" >The Foundation of Justice And Knowledge.</p>
        </div>

        <div class="text-center mt-4">
            <a href="register.php" class="btn btn-primary btn-lg">Register</a>
            <a href="login.php" class="btn btn-secondary btn-lg">Login</a>
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    <div class="navbar-bottom">
        <p>&copy; 2024 Meru Law Court Library Management System. All rights reserved.</p>
        <div>
        <a href="https://email.com" target="_blank">Email</a> |
            <a href="https://facebook.com" target="_blank">Facebook</a> |
            <a href="https://wa.me/yourphonenumber">WhatsApp</a> | 
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