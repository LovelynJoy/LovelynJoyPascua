<?php
include 'db.php'; // Include your database connection file

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
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=your_database_name', 'your_username', 'your_password');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Prepare an SQL statement to prevent SQL injection
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone_number, username, password) VALUES (?, ?, ?, ?, ?, ?)");
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            
            // Execute the statement with user input
            $stmt->execute([$first_name, $last_name, $email, $phone_number, $username, $hashed_password]);

            echo "<div class='success'>Registration successful!</div>";
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    } else {
        // Display errors if any
        foreach ($errors as $error) {
            echo "<div class='error'>$error</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        .success { color: green; }
        .error { color: red; }
        body {
            text-align: center;
            font-size: 20px; /* Adjusted font size for better readability */
            margin: 0; /* Remove default margin */
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
        form {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background for the form */
            padding: 50px; /* Padding around the form */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Shadow for depth */
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required>
        <br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>