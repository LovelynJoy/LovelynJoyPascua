<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Room Reservation Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <img src="https://static.vecteezy.com/system/resources/previews/023/602/395/original/the-hotel-logo-design-by-h-the-hotel-free-vector.jpg" alt="Description of image" style="width: 100px; height: auto;">
    <style>
        .kpi {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .kpi div {
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin: 0 10px;
        }
        .availability-calendar {
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #35424a;
            color: #ffffff;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header class="navbar is-primary">
        <div class="navbar-brand">
            <a class="navbar-item" href="#">Hotel Logo</a>
            <div class="navbar-burger" data-target="navbarMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div id="navbarMenu" class="navbar-menu">
            <div class="navbar-end">
                <div class="navbar-item">
                    Welcome, User
                </div>
                <div class="navbar-item">
                    <button class="button is-light">Logout</button>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar">
        <div class ="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="#">Dashboard</a>
                <a class="navbar-item" href="reservations.php">Reservations</a>
                <a class="navbar-item" href="rooms.php">Rooms</a>
                <a class="navbar-item" href="guests.php">Guests</a>
            </div>
        </div>
    </nav>

    <main class="section">
        <div class="container">
            <section class="kpi">
                <div>Total Reservations: 0</div>
                <div>Occupancy Rate: 0%</div>
                <div>Revenue: $0</div>
                <div>Upcoming Check-ins: 0</div>
                <div>New Guests: 0</div>
            </section>
            
            <section class="reservations-table">
                <h2 class="title">Current Reservations</h2>
                <table class="table is-striped is-fullwidth">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Room Type</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="has-text-centered">No current reservations</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="room-availability">
                <h2 class="title">Room Availability</h2>
                <div class="availability-calendar">
                    <p>Calendar view or chart showing room availability will be displayed here.</p>
                </div>
            </section>

            <section class="recent-activity">
                <h2 class="title">Recent Activity</h2>
                <ul>
                    <li>No recent activity.</li>
                </ul>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Hotel Reservation System. All rights reserved.</p>
    </footer>
</body>
</html>