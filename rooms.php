<?php
include 'db.php'; // Include the database connection

// Handle form submission for adding a new room
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_room'])) {
    $room_type = $_POST['room_type'];
    $status = $_POST['status'];

    $sql = "INSERT INTO rooms (room_type, status) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $room_type, $status);

    if ($stmt->execute()) {
        echo "<p class='notification is-success'>Room added successfully!</p>";
    } else {
        echo "<p class='notification is-danger'>Error adding room: " . $conn->error . "</p>";
    }

    $stmt->close();
}

// Handle room deletion
if (isset($_GET['delete'])) {
    $room_id = $_GET['delete'];

    $sql = "DELETE FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);

    if ($stmt->execute()) {
        echo "<p class='notification is-success'>Room deleted successfully!</p>";
    } else {
        echo "<p class='notification is-danger'>Error deleting room: " . $conn->error . "</p>";
    }

    $stmt->close();
}

// Fetch all rooms
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Room Management</h1>

        <!-- Add Room Form -->
        <form method="POST">
            <div class="field">
                <label class="label">Room Type</label>
                <div class="control">
                    <input class="input" type="text" name="room_type" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Status</label>
                <div class="control">
                    <div class="select">
                        <select name="status" required>
                            <option value="available">Available</option>
                            <option value="reserved">Reserved</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="control">
                <button class="button is-primary" type="submit" name="add_room">Add Room</button>
            </div>
        </form>

        <!-- Rooms Table -->
        <h2 class="title is-4">Current Rooms</h2>
        <table class="table is-striped is-fullwidth">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['room_type']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <a href='rooms.php?delete={$row['id']}' class='button is-danger is-small'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No rooms available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>