<?php
// Include database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check_stmt = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Username or Email already exists!";
        exit;
    }

    // Insert user data into the appropriate table
    if ($role == 'librarian') {
        $stmt = $conn->prepare("INSERT INTO librarians (full_name, username, phone, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $username, $phone, $email, $hashed_password);
    } else {
        // Ensure 'admin' role is handled correctly
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, phone, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $full_name, $username, $phone, $email, $hashed_password, $role);
    }

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        a {
            text-decoration: none;
            color: #4CAF50;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="">
        <label>Full Name:</label>
        <input type="text" name="full_name" required><br>

        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Phone Number:</label>
        <input type="text" name="phone" required><br>

        <label>Email Address:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required><br>

        <label>Register as:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="librarian">Librarian</option>
        </select><br>

        <input type="submit" value="Register">
    </form>
    <a href="login.php">Already have an account? Log in</a>
</body>
</html>
