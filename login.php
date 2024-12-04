<?php
session_start(); // Start the session to manage user login state

// Check if the user is already logged in, redirect if necessary
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php"); // Redirect to a dashboard or home page
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection settings
    $servername = "localhost";
    $username = "root"; // Change to your database username
    $password = ""; // Change to your database password
    $dbname = "hotel_reservation"; // Change to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect and sanitize input data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, fetch the hashed password
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['username'] = $username;
            header("Location: dashboard.php"); // Redirect to a dashboard or home page
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close(); // Close the database connection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2 class="title has-text-centered">Login</h2>
        <?php if (isset($error)): ?>
            <div class="notification is-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
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
                <div class="control">
                    <input class="button is-primary" type="submit" value="Login">
                </div>
            </div>
        </form>
        <p class="has-text-centered">Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>