<?php
include APP_DIR.'views/templates/header.php';
?>
<body>
    <div id="app">
    <?php
    include APP_DIR.'views/templates/nav.php';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: 'Arial', sans-serif;
        }

        .container {
            padding: 2rem 5%;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0056b3;
        }

        .table {
            margin-top: 1.5rem;
        }

        .btn {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
        }

        .btn-primary:hover {
            background-color: #004494;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #555555;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #003060;
            padding-top: 20px;
            color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease; 
        }

        .sidebar.visible {
            left: 0; 
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            border-bottom: 1px solid #d1d1d1;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #055c9d;
        }

        .sidebar .active {
            background-color: #0E86D4;
        }

        .sidebar-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

         .hamburger {
            position: absolute;
            top: 15px;
            left: 15px;
            cursor: pointer;
            z-index: 1000;
            font-size: 25px;
            background-color: #003060;
            color: white;
            border: none;
            padding: 5px 8px;
            border-radius: 5px;
            opacity: 1;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .hamburger:hover {
            background-color: #055c9d;
        }
 
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #003060;
            transition: all 0.3s ease;
            padding-top: 40px;
            padding-left: 15px;
        }

        .sidebar.visible {
            left: 0; 
        }

        .sidebar.visible .hamburger {
            opacity: 0;
        }

        .status-badge {
    padding: 0.4rem 1rem;
    border-radius: 15px;
    font-weight: bold;
    color: white;
    display: inline-block;
}

.status-approved {
    background-color: #28a745; /* Green */
}

.status-pending {
    background-color: #ffc107; /* Yellow */
}

.status-rejected {
    background-color: #dc3545; /* Red */
}

/* Button Styles */
button {
    padding: 0.3rem 1.2rem;
    border-radius: 5px;
    font-weight: bold;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Approve Button */
.approve-btn {
    background-color: #28a745; /* Green */
}

.approve-btn:hover {
    background-color: #218838; /* Darker green on hover */
}

/* Reject Button */
.reject-btn {
    background-color: #dc3545; /* Red */
}

.reject-btn:hover {
    background-color: #c82333; /* Darker red on hover */
}

/* Optional: Add padding to the form so buttons are spaced out */
form {
    margin-right: 10px;
}


    </style>
</head>
<body>
<button class="hamburger" id="hamburger">☰</button>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span>Organizer Dashboard</span>
    </div>
    <a href="<?= site_url('/organizer/dashboard'); ?>" id="events-link" >Events</a>
    <a href="<?= site_url('/organizer/manage_booking'); ?>" id="booking-link" class="active">Manage Bookings</a>
</div>
    <div class="container">
        <h1 class="text-center mb-4">Organizer Dashboard</h1>

        <!-- Pending Bookings -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pending Bookings</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Event</th>
                            <th>User Email</th>
                            <th>Booking Date</th>
                            <th>Ticket Quantity</th>
                            <th>Ticket Number</th>
                            <th>Reminder Set</th>
                            <th>Reminder Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking) : ?>
                            <?php if ($booking['status'] == 'pending'): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['booking_id'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['event_title'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['user_email'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['booking_date'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['ticket_quantity'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['ticket_number'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['reminder_set'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['reminder_date'] ?? 'N/A'); ?></td>
                                <td>
                                    <!-- Approve Booking Form -->
<form method="post" action="<?= site_url('/organizer/approve_booking/'.$booking['booking_id']); ?>" style="display:inline-block;" onsubmit="return confirmApprove();">
    <input type="hidden" name="booking_id" value="<?= $booking['booking_id']; ?>">
    <button type="submit" class="approve-btn">Approve</button>
</form>

<!-- Reject Booking Form -->
<form method="post" action="<?= site_url('/organizer/reject_booking/'.$booking['booking_id']); ?>" style="display:inline-block;" onsubmit="return confirmDelete();">
    <input type="hidden" name="booking_id" value="<?= $booking['booking_id']; ?>">
    <button type="submit" class="reject-btn">Reject</button>
</form>

                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Approved Bookings -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Approved Bookings</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Event</th>
                            <th>User Email</th>
                            <th>Booking Date</th>
                            <th>Ticket Quantity</th>
                            <th>Ticket Number</th>
                            <th>Reminder Set</th>
                            <th>Reminder Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking) : ?>
                            <?php if ($booking['status'] == 'approved'): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['booking_id'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['event_title'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['user_email'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['booking_date'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['ticket_quantity'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['ticket_number'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['reminder_set'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['reminder_date'] ?? 'N/A'); ?></td>
                               <!-- For Approved Status -->
                               <td>
    <span class="status-badge status-<?= strtolower($booking['status']); ?>">
        <?= $booking['status']; ?>
    </span>
</td>

                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Rejected Bookings -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rejected Bookings</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Event</th>
                            <th>User Email</th>
                            <th>Booking Date</th>
                            <th>Ticket Quantity</th>
                            <th>Ticket Number</th>
                            <th>Reminder Set</th>
                            <th>Reminder Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking) : ?>
                            <?php if ($booking['status'] == 'rejected'): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['booking_id'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['event_title'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['user_email'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['booking_date'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['ticket_quantity'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['ticket_number'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['reminder_set'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($booking['reminder_date'] ?? 'N/A'); ?></td>
                                <td>
    <span class="status-badge status-<?= strtolower($booking['status']); ?>">
        <?= $booking['status']; ?>
    </span>
</td>

                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Your Organization. All rights reserved.</p>
    </footer>

    <script>
        // Hamburger menu toggle
        const hamburger = document.getElementById("hamburger");
        const sidebar = document.getElementById("sidebar");

        hamburger.addEventListener("click", () => {
            sidebar.classList.toggle("visible");
        });

        function confirmDelete() {
            return confirm('Are you sure you want to reject this booking?');
        }
        function confirmApprove() {
            return confirm('Approve this booking?');
        }
    </script>
</body>
</html>
