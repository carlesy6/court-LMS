<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MERU LAW COURT LIBRARY MANAGEMENT SYSTEM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome for social media icons -->
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
            color: black;
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
            color: black; 
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
            color: white; /* Text color for all resource columns */
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

        /* Social media icon styles */
        .social-icons a {
            font-size: 20px; /* Increase the icon size */
            color: white; /* Icon color */
            margin: 0 10px; /* Space between icons */
            transition: color 0.3s ease; /* Smooth color transition */
        }

        .social-icons a:hover {
            color: #f0f8ff; /* Icon color on hover */
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <div class="navbar-top">
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="view_resources.php">View resources</a>
        <a href="add_resource.php">Add Resource</a>
    </div>

    <div class="container">
        <div class="text-center mt-5">
            <h1 class="display-4">MERU LAW COURT LIBRARY MANAGEMENT SYSTEM</h1>
            <p class="lead">Welcome to Meru Law Court.</p> 
            <p class="lead">The Foundation of Justice And Knowledge.</p>
        </div>

        <div class="text-center mt-4">
            <a href="register.php" class="btn btn-primary btn-lg">Register</a>
            <a href="login.php" class="btn btn-secondary btn-lg">Login</a>
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    <div class="navbar-bottom">
        <p>&copy; 2024 Meru Law Court Library Management System. All rights reserved.</p>
        Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a>
        <div class="social-icons">
            <a href="mailto:catemuthoni@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
            <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a> |
            
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
