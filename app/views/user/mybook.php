
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- FontAwesome for icons -->
    <style>
        body {
            background: linear-gradient(135deg, #e9ecef, #f8f9fa);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .container {
            padding: 3rem 5%;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2.5rem;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #007bff;
        }

        .table {
            margin-top: 1.5rem;
            border-collapse: collapse;
            width: 100%;
        }

        .table th, .table td {
            padding: 1rem;
            text-align: center;
            vertical-align: middle;
        }

        .btn {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 0.5rem 1.25rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.95rem;
            color: #555555;
            padding: 1rem;
            background-color: #f8f9fa;
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

        .status-cancelled {
            background-color:rgb(220, 53, 164); /* Violet */
        }

        .reminder-yes {
            color: #28a745;
        }

        .reminder-no {
            color: #dc3545;
        }

        .no-booking-message {
            text-align: center;
            font-size: 1.5rem;
            color: #e74c3c; /* A noticeable color */
            margin-top: 2rem;
            font-weight: 500;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .action-icons i {
            font-size: 1.2rem;
            margin: 0 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .action-icons i:hover {
            transform: scale(1.2);
        }

        .cancelled-label {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include APP_DIR.'views/user/header.php'; ?>
    <div class="container">
        <h1 class="text-center">Your Bookings</h1>

        <!-- Check if there are bookings -->
        <?php if (empty($bookings)) : ?>
            <div class="no-booking-message">
                <p>You haven't booked anything yet. Book an event now!</p>
            </div>
        <?php else : ?>
            <!-- All Bookings -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">My Bookings</h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Event</th>
                                <th>Booking Date</th>
                                <th>Ticket Quantity</th>
                                <th>Status</th>
                                <th>Reminder Set</th>
                                <?php if ($bookings[0]['reminder_set'] === 'Yes') : ?>
                                    <th>Reminder Date</th>
                                <?php endif; ?>
                                <th>Ticket Number</th>
                                <th>Action</th> <!-- Added Action Column -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($booking['booking_id'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($booking['event_title'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($booking['booking_date'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($booking['ticket_quantity'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($booking['status']); ?>">
                                            <?= $booking['status']; ?>
                                        </span>
                                    </td>
                                    <td class="<?= $booking['reminder_set'] === 'Yes' ? 'reminder-yes' : 'reminder-no'; ?>">
                                        <?= $booking['reminder_set'] === 'Yes' ? 'Yes' : 'No'; ?>
                                    </td>
                                    <?php if ($booking['reminder_set'] === 'Yes') : ?>
                                        <td><?= htmlspecialchars($booking['reminder_date'] ?? 'N/A'); ?></td>
                                    <?php endif; ?>
                                    <td><?= htmlspecialchars($booking['ticket_number'] ?? 'N/A'); ?></td>
                                    <td class="action-icons">
                                        <?php if ($booking['status'] !== 'cancelled') : ?>
                                            <!-- Cancel Booking Form -->
                                            <form method="post" action="<?= site_url('/user/cancel_booking/'.$booking['booking_id']); ?>" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                <input type="hidden" name="booking_id" value="<?= $booking['booking_id']; ?>">
                                                <button type="submit" class="btn btn-link text-danger" title="Cancel Booking">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        <?php else : ?>
                                            <span class="cancelled-label">Cancelled</span>
                                        <?php endif; ?>

                                        <!-- View Email Form -->
                                        <form method="post" action="<?= site_url('/user/view_email/'.$booking['booking_id']); ?>" style="display:inline-block;">
                                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id']; ?>">
                                            <button type="submit" class="btn btn-link text-primary" title="View Email">
                                                <i class="fas fa-envelope-open-text"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> Your Organization. All rights reserved.</p>
    </footer>

    <script>
        // Optional JavaScript code if needed for user-side interaction
    </script>
</body>
</html>
