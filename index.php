<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MERU HIGH COURT LIBRARY MANAGEMENT SYSTEM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome for social media icons -->
    
    <!-- Google Fonts for modern condensed serif -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* Apply a background color and image to the whole page */
        body {
            font-family: 'IBM Plex Serif', serif; /* Updated to modern condensed serif font */
            background-color: black;
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
            background-color: black;
            padding: 10px; /* Padding around the navbar */
            text-align: center; /* Center text in navbar */
            position: relative; /* Make navbar a positioned container */
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
            font-family: 'IBM Plex Serif', serif; /* Updated to modern condensed serif font */
            color: cream; 
            border-block-color: black;
        }

        /* Paragraphs and other text */
        p, li {
            font-family: 'IBM Plex Serif', serif; /* Updated to modern condensed serif font */
            color: white;
        }

        /* Links */
        a {
            font-family: 'IBM Plex Serif', serif; /* Updated to modern condensed serif font */
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
            font-family: 'IBM Plex Serif', serif; /* Updated to modern condensed serif font */
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
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: relative; /* Ensure it's a positioned container */
        }

        /* Developer info at the bottom right corner */
        .developer-info {
            position: absolute;
            bottom: 10px;
            right: 10px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .developer-info img {
            border-radius: 50%; /* Circular image */
            width: 40px; /* Image size */
            height: 40px; /* Maintain aspect ratio */
            margin-bottom: 10px; /* Space between image and text */
        }

        .developer-info span {
            display: block;
            text-align: center;
        }

        .social-icons a {
            font-size: 20px; /* Increase the icon size */
            color: white; /* Icon color */
            margin: 0 10px; /* Space between icons */
            transition: color 0.3s ease; /* Smooth color transition */
        }

        .social-icons a:hover {
            color: #f0f8ff; /* Icon color on hover */
        }

        /* Add logo styling */
        .navbar-top img.logo {
            width: 100px; /* Set the width of the logo */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 10px; /* Space between logo and links */
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <div class="navbar-top">
        <!-- Logo Image -->
        <img src="logo.jfif" alt="Logo" class="logo"> <!-- Update with your image path -->
        
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="librarian_dashboard.php">Librarian Dashboard</a>
        <a href="view_resources.php">View resources</a>
        <a href="add_resource.php">Add Resource</a>
        <a href="borrowed_resources.php">Borrowed Resources</a>
    </div>

    <div class="container">
        <div class="text-center mt-5">
            <h1 class="display-4">MERU HIGH COURT LIBRARY MANAGEMENT SYSTEM</h1>
            <p class="lead">Welcome to Meru High Court.</p> 
            <p class="lead">The Foundation of Justice And Knowledge.</p>
        </div>

        <div class="text-center mt-4">
            <a href="register.php" class="btn btn-primary btn-lg">Register</a>
            <a href="login.php" class="btn btn-secondary btn-lg">Login</a>
        </div>
    </div>

    <!-- Bottom Navigation Bar -->
    <div class="navbar-bottom">
        <p>&copy; 2024 Meru High Court Library Management System. All rights reserved.</p>
        Contact us at: <i class="fas fa-phone-alt"></i> <a href="tel:+254722790240">+254 722 790 240</a>
        <div class="social-icons">
            <a href="mailto:catemuthoni@gmail.com"><i class="fas fa-envelope"></i> Email</a> |
            <a href="https://wa.me/0722790240"><i class="fab fa-whatsapp"></i> WhatsApp</a> |
        </div>
        <div class="developer-info">
            <img src="PIC.jpg" alt="Developer Image"> <!-- Update with developer's image path -->
            <span>Developed by</span>
            <span>OTIENO CELESTINO ONYANGO</span>
            <span>0714019736</span>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>