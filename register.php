<?php
session_start(); 
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    $errors = [];

    // Validate input fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number) || empty($username) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If there are no errors, proceed with database insertion
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, phone_number, username, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone_number, $username, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to login.php after successful registration
            header("Location: login.php");
            exit();
        } else {
            echo "<div class='notification is-danger'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } else {
        // Display errors if any
        foreach ($errors as $error) {
            echo "<div class='notification is-danger'>$error</div>";
        }
    }
}

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <style>
        body {
            height: 100vh; /* Full viewport height */
            display: flex; /* Use flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            background-color: #333; /* Fallback color */
            background-image: url('https://cpimg.tistatic.com/08235612/b/4/Pastel-Brown.jpg'); /* Set your background image */
            background-size: cover; /* Cover the entire body */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
        }
        .form-container {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background for the form */
            padding: 50px; /* Padding around the form */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Shadow for depth */
            width: 400px; /* Fixed width for the form */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="title has-text-centered">Register</h2>
        <form method="POST" action="">
            <div class="field">
                <label class="label" for="first_name">First Name:</label>
                <div class="control">
                    <input class="input" type="text" name="first_name" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="last_name">Last Name:</label>
                <div class="control">
                    <input class="input" type="text" name="last_name" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="email">Email:</label>
                <div class="control">
                    <input class="input" type="email" name="email" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="phone_number">Phone Number:</label>
                <div class="control">
                    <input class="input" type="text" name="phone_number" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="username">Username:</label>
                <div class="control">
                    <input class="input" type="text" name="username" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="password">Password:</label>
                <div class="control">
                    <input class="input" type="password" name="password" required>
                </div>
            </div>
            <div class="field">
                <label class="label" for="confirm_password">Confirm Password:</label>
                <div class="control">
                    <input class="input" type="password" name="confirm_password" required>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <input class="button is-primary" type="submit" value="Register">
                </div>
            </div>
        </form>
        <p class="has-text-centered">Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>