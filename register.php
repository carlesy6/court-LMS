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

    // Validate password strength
    if (!isPasswordStrong($password)) {
        echo "Password does not meet the required strength criteria!";
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

// Function to check password strength
function isPasswordStrong($password) {
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasDigit = preg_match('/[0-9]/', $password);
    $hasSpecialChar = preg_match('/[\W]/', $password);
    $hasMinLength = strlen($password) >= 8;

    return $hasUppercase && $hasLowercase && $hasDigit && $hasSpecialChar && $hasMinLength;
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
        .strength {
            margin: 8px 0;
            font-weight: bold;
            color: red;
        }
        .toggle-password {
            margin: 8px 0;
            display: inline-block;
            cursor: pointer;
            color: #4CAF50;
        }
        .toggle-password:hover {
            color: #45a049;
        }
    </style>
    <script>
        function checkPasswordStrength() {
            var password = document.getElementById('password').value;
            var strengthMessage = document.getElementById('strengthMessage');

            // Regular expressions for password checks
            var hasUppercase = /[A-Z]/.test(password);
            var hasLowercase = /[a-z]/.test(password);
            var hasDigit = /[0-9]/.test(password);
            var hasSpecialChar = /[\W]/.test(password);
            var hasMinLength = password.length >= 8;

            // Count the number of criteria met
            var strengthCount = hasUppercase + hasLowercase + hasDigit + hasSpecialChar + hasMinLength;

            // Update strength message based on the number of criteria met
            if (strengthCount === 5) {
                strengthMessage.style.color = 'green';
                strengthMessage.textContent = 'Strong Password';
            } else if (strengthCount >= 3) {
                strengthMessage.style.color = 'orange';
                strengthMessage.textContent = 'Moderate Password';
            } else {
                strengthMessage.style.color = 'red';
                strengthMessage.textContent = 'Weak Password';
            }
        }

        function togglePasswordVisibility(inputId, checkboxId) {
            var inputField = document.getElementById(inputId);
            var checkbox = document.getElementById(checkboxId);

            if (checkbox.checked) {
                inputField.type = 'text';
            } else {
                inputField.type = 'password';
            }
        }
    </script>
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
        <input type="password" id="password" name="password" required onkeyup="checkPasswordStrength()"><br>
        <input type="checkbox" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')">
        <label class="toggle-password" for="togglePassword">Show Password</label><br>
        <div id="strengthMessage" class="strength">Weak Password</div>

        <label>Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <input type="checkbox" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPassword')">
        <label class="toggle-password" for="toggleConfirmPassword">Show Password</label><br>

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
