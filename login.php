<?php
// Include database connection
include('db.php'); // This ensures $pdo is available in this script

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']); // Retrieve username
    $password = $_POST['password']; // Retrieve password

    // Check if the user selected a role
    if (isset($_POST['role'])) {
        $role = $_POST['role']; // Retrieve role selection

        if ($role == 'librarian') {
            // Prepare a statement to get librarian details
            $stmt = $pdo->prepare("SELECT id, password FROM librarians WHERE username = ?");
            $stmt->execute([$username]); // Execute the prepared statement with bound parameters
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch results

            // Check if a row was returned
            if ($result) {
                $id = $result['id'];
                $hashed_password = $result['password'];

                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    // Store user information in session
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    
                    // Redirect both roles to the same dashboard
                    header("Location: index.php"); // Redirect to the librarian dashboard
                    exit;
                } else {
                    echo "Invalid username or password!";
                }
            } else {
                echo "Invalid username or password!";
            }
        } else if ($role == 'admin') {
            // Prepare a statement to get admin details
            $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ? AND role = ?");
            $stmt->execute([$username, $role]); // Execute the prepared statement with bound parameters
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch results

            // Check if a row was returned
            if ($result) {
                $id = $result['id'];
                $hashed_password = $result['password'];

                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    // Store user information in session
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    
                    // Redirect both roles to the same dashboard
                    header("Location: index.php"); // Redirect to the librarian dashboard
                    exit;
                } else {
                    echo "Invalid username or password!";
                }
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "Invalid role selected!";
            exit; // Exit if an invalid role is selected
        }
    } else {
        echo "Please select a role!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        input[type="text"], input[type="password"], select {
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
    <h2>Login</h2>
    <form method="post" action="">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Login as:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="librarian">Librarian</option>
        </select><br>

        <input type="submit" value="Log In">
    </form>
    <a href="register.php">Don't have an account? Register</a>
</body>
</html>
