<?php
include 'db.php'; // Include the database connection

// Handle form submission for adding a new guest
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_guest'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    $sql = "INSERT INTO guests (first_name, last_name, email, phone_number) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $phone_number);

    if ($stmt->execute()) {
        echo "<p class='notification is-success'>Guest added successfully!</p>";
    } else {
        echo "<p class='notification is-danger'>Error adding guest: " . $conn->error . "</p>";
    }

    $stmt->close();
}

// Handle guest deletion
if (isset($_GET['delete'])) {
    $guest_id = $_GET['delete'];

    $sql = "DELETE FROM guests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $guest_id);

    if ($stmt->execute()) {
        echo "<p class='notification is-success'>Guest deleted successfully!</p>";
    } else {
        echo "<p class='notification is-danger'>Error deleting guest: " . $conn->error . "</p>";
    }

    $stmt->close();
}

// Fetch all guests
$sql = "SELECT * FROM guests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Guest Management</h1>

        <!-- Add Guest Form -->
        <form method="POST">
            <div class="field">
                <label class="label">First_name</label>
                <div class="control">
                    <input class="input" type="text" name="first_name" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Last_name</label>
                <div class="control">
                    <input class="input" type="text" name="last_name" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input class="input" type="email" name="email" required>
                </div>
            <div class="field">
                <label class="label">Phone_number</label>
                <div class="control">
                    <input class="input" type="text" name="phone_number" required>
                </div>
            <div class="control">
                <button class="button is-primary" type="submit" name="add_guest">Add Guest</button>
            </div>
        </form>

        <!-- Guests Table -->
        <h2 class="title is-4">Current Guests</h2>
        <table class="table is-striped is-fullwidth">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['first_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone_number']}</td>
                                <td>
                                    <a href='guests.php?delete={$row['id']}' class='button is-danger is-small'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No guests available.</td></tr>";
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