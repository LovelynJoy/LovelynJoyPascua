<?php
session_start(); 
include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Room Reservation System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; 
            background-image: url('https://i.pinimg.com/originals/ef/2d/1e/ef2d1e921111328346c56b5587c490b5.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
        }
        header {
            background: blue (53, 66, 74, 0.8); 
            color: #ffffff;
            padding: 30px 0;
            text-align: center;
            font-family: arial, sans-serif;
       
        }
        nav {
            margin: 20px 0;
        }
        nav a {
            margin: 0 15px;
            color: white;
            text-decoration: underline blue;
            font-size: 40px;
        }
        .container {
            width: 100%;
            margin: 20px 0;
            overflow: hidden;
            text-align: center;
        }
        .room {
            border: 2px solid #ccc;
            margin: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.9); 
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to Hotely</h1>

</header>

<nav>
    <div class="container">
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    
    <?php if (empty($rooms)): ?>
       
    <?php else: ?>
        <?php foreach ($rooms as $room): ?>
            <div class="room">
                <h3><?php echo htmlspecialchars($room['room_type']); ?></h3>
                <p>Price: $<?php echo htmlspecialchars($room['price']); ?> per night</p>
                <p>Description: <?php echo htmlspecialchars($room['description']); ?></p>
                <a href="reserve.php?room_id=<?php echo $room['id']; ?>">Reserve Now</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>