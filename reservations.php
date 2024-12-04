<?php
include 'db.php';

// Adjust the SQL query to remove the status column
$sql = "SELECT g.id AS guests_name, room_type, res.check_in, res.check_out
        FROM reservations res
        JOIN guests g ON guests_name = guests_name
        JOIN rooms r ON room_type = room_type";
        
        try {
            $result = $conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
            exit; // Stop execution if there's an error
        }
        ?>


<section class="reservations-table">
    <h2 class="title is-4">Current Reservations</h2>
    <table class="table is-striped is-fullwidth">
        <thead>
            <tr>
                <th>Guest Name</th>
                <th>Room Type</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data for each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['guest_name']}</td>
                            <td>{$row['room_type']}</td>
                            <td>{$row['check_in']}</td>
                            <td>{$row['check_out']}</td>
                            <td>

                                <a href='reservations.php?delete={$row['id']}' class='button is-danger is-small'>Delete</a>
                                <button class='button is-small'>Edit</button>
                                <button class='button is-small'>Cancel</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No current reservations</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<?php
$conn->close(); // Close the connection
?>