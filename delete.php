<?php

$host = 'localhost'; 
$dbname = 'hotel_reservation'; 
$username = 'root'; 
$password = ''; 

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        
        $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = :id");
        $stmt->bindParam(':id', $id);

      
        if ($stmt->execute()) {
            echo "Reservation deleted successfully.";
        } else {
            echo "Error deleting reservation.";
        }
    } else {
        echo "No reservation ID provided.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$pdo = null;
?>


<a href="guests.php">Back to Reservations</a>