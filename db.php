<?php
$host = 'localhost';
$dbname = 'hotel_reservation';
$username = 'root'; // Replace with your MySQL username
$password = '';   // Replace with your MySQL password


$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>